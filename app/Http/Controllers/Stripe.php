<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\reservationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;

class Stripe extends Controller
{
    public function stripePayment(Request $request)
    {
        $user = auth()->guard('userModel')->user();

        // Only the owner of an Unpaid reservation can start a payment for it
        $reservation = reservationModel::where('reservation_id', $request->input('reservation_id'))
            ->where('user_id', $user->user_id)
            ->where('status', 'Unpaid')
            ->first();

        if (!$reservation) {
            return redirect()->route('cancel');
        }

        $stripe = new StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'PHP',
                    'product_data' => ['name' => 'Total Value'],
                    'unit_amount' => (int) round($request->input('total_payment') * 100),
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'reservation_id' => (string) $reservation->reservation_id,
                'type_of_room' => $request->input('type_of_room'),
                'total_nights' => $request->input('total_nights'),
                'user_email' => $user->email,
            ],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        if (!empty($response->url)) {
            return redirect($response->url);
        }

        return redirect()->route('cancel');
    }

    // Browser return after paying (fast path). The webhook is the safety net.
    public function success(Request $request)
    {
        if (!$request->session_id) {
            return redirect()->route('cancel');
        }

        $stripe = new StripeClient(config('stripe.stripe_sk'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        $user = auth()->guard('userModel')->user();
        if (strcasecmp((string) $session->metadata->user_email, (string) $user->email) !== 0) {
            return redirect()->route('cancel');
        }

        if (!$this->fulfill($session)) {
            return redirect()->route('cancel')->with('message', 'Payment not completed.');
        }

        return redirect()->route('customerUnpaidReservation')->with('message', 'Payment is successful');
    }

    public function cancel()
    {
        return redirect()->route('customerUnpaidReservation')->with('message', 'Payment is cancelled');
    }

    // Stripe -> server notification
    public function webhook(Request $request)
    {
        $secret = config('stripe.webhook_secret');
        if (!$secret) {
            Log::error('Stripe webhook called but STRIPE_WEBHOOK_SECRET is not set.');
            return response('Webhook not configured', 400);
        }

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                (string) $request->header('Stripe-Signature'),
                $secret
            );
        } catch (\UnexpectedValueException | SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if (in_array($event->type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)) {
            $this->fulfill($event->data->object);
        }

        return response('ok', 200);
    }

    // Idempotent: safe to call from both success() and webhook(), any number of times
    private function fulfill($session): bool
    {
        if (($session->payment_status ?? null) !== 'paid') {
            return false;
        }

        $reservationId = $session->metadata->reservation_id ?? null;
        if (!$reservationId) {
            Log::warning('Stripe session without reservation_id: ' . $session->id);
            return false;
        }

        return Cache::lock('stripe-fulfill-' . $session->id, 10)->block(5, function () use ($session, $reservationId) {
            DB::transaction(function () use ($session, $reservationId) {
                if (!Payment::where('payment_id', $session->id)->exists()) {
                    $payment = new Payment();
                    $payment->payment_id = $session->id;
                    $payment->amount = $session->amount_total / 100;
                    $payment->customer_email = $session->metadata->user_email ?? $session->customer_details->email ?? '';
                    $payment->payment_status = $session->payment_status;
                    $payment->payment_method = 'Stripe';
                    $payment->save();
                }

                reservationModel::where('reservation_id', $reservationId)
                    ->where('status', 'Unpaid')
                    ->update(['status' => 'Pending']);
            });
            return true;
        });
    }
}