<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\reservationModel;
use Carbon\Carbon;
use Stripe\StripeClient;

class ReservationRefund
{
    public const FULL_REFUND_HOURS = 48;

    public static function isFullRefund(Carbon $checkIn, Carbon $now): bool
    {
        return $now->diffInHours($checkIn, false) >= self::FULL_REFUND_HOURS;
    }

    public function plan(reservationModel $r): array
    {
        if ($r->status === 'Unpaid') {
            return ['allowed' => true, 'refund' => 0.0, 'payment' => null,
                'message' => 'This booking has not been paid, so nothing will be charged or refunded.'];
        }

        $now = Carbon::now('Asia/Manila');
        $checkIn = Carbon::parse($r->start_dataTime, 'Asia/Manila');

        if ($now->gte($checkIn)) {
            return ['allowed' => false, 'refund' => 0.0, 'payment' => null,
                'message' => 'Check-in time has passed. Please contact the hotel.'];
        }

        $payment = Payment::where('reservation_id', $r->reservation_id)
            ->where('payment_status', 'paid')->latest('id')->first();

        if (!$payment) {
            return ['allowed' => false, 'refund' => 0.0, 'payment' => null,
                'message' => 'We could not find your payment. Please contact the hotel.'];
        }

        $paid = (float) $payment->amount;

        if (self::isFullRefund($checkIn, $now)) {
            return ['allowed' => true, 'refund' => $paid, 'payment' => $payment,
                'message' => 'Your deposit of ₱' . number_format($paid, 2) . ' will be refunded to your card (5-10 business days).'];
        }

        return ['allowed' => true, 'refund' => 0.0, 'payment' => $payment,
            'message' => 'Check-in is less than ' . self::FULL_REFUND_HOURS . ' hours away, so your deposit of ₱'
                . number_format($paid, 2) . ' is non-refundable.'];
    }

    // Returns the Stripe refund id. Idempotent per reservation (double clicks are safe).
    public function refund(Payment $payment, float $amount, int $reservationId): string
    {
        $stripe = new StripeClient(config('stripe.stripe_sk'));

        $intent = $payment->payment_intent
            ?: $stripe->checkout->sessions->retrieve($payment->payment_id)->payment_intent;

        $refund = $stripe->refunds->create([
            'payment_intent' => $intent,
            'amount' => (int) round($amount * 100),
            'metadata' => ['reservation_id' => (string) $reservationId],
        ], ['idempotency_key' => 'refund-reservation-' . $reservationId]);

        return $refund->id;
    }
}