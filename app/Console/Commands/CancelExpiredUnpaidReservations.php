<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\reservationModel;
use Carbon\Carbon;

class CancelExpiredUnpaidReservations extends Command
{
    protected $signature = 'reservations:cancel-expired-unpaid';
    protected $description = 'Delete unpaid reservations that have exceeded the payment window';

    public function handle()
    {
        $expiryMinutes = 20;

        $expired = reservationModel::where('status', 'Unpaid')
            ->where('created_at', '<=', Carbon::now()->subMinutes($expiryMinutes))
            ->get();

        $count = $expired->count();

        foreach ($expired as $reservation) {
            $reservation->delete();
        }

        $this->info("Cancelled {$count} expired unpaid reservation(s).");
    }
}