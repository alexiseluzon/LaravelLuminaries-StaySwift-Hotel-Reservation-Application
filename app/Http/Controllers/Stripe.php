<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservationModel;
use App\Models\Payment;

class Stripe extends Controller
{
    public function stripePayment(Request $request)
    {
        $totalPayment = $request->input('total_payment');
        $typeOfRoom = $request->input('type_of_room');
        $totalNights = $request->input('total_nights');
        $user = auth()->guard('userModel')->user();
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'PHP',
                        'product_data' => [
                            'name' => 'Total Value',
                        ],
                        'unit_amount' => $totalPayment * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'metadata' => [
                'type_of_room' => $typeOfRoom,
                'total_nights' => $totalNights,
                'user_email' => $user->email,
            ],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' =>  route('cancel'),
        ]);

        if (isset($response->id) && $response->id != '') {
            session()->put('total_payment', $request->total_payment);
            session()->put('reservation_id', $request->reservation_id);
            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        if (isset($request->session_id)) {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->amount = session()->get('total_payment');
            $payment->customer_email = $response->metadata->user_email;
            $payment->payment_status = $response->status;
            $payment->payment_method = "Stripe";
            $payment->save();
            $reservedId = session()->get('reservation_id');
            $reservation = reservationModel::where('reservation_id', $reservedId)->first();
            if ($reservation) {
                $reservation->update(['status' => 'Pending']);
            } else {
                return redirect()->route('cancel')->with('message', 'Reservation not found.');
            }
            return redirect()->route('customerUnpaidReservation')->with('message', 'Payment is successful');
        } else {
            return redirect()->route('cancel');
        }
    }

    public function cancel()
    {
        return redirect()->route('customerUnpaidReservation')->with('message', 'Payment is cancelled');
    }
}
