<?php

namespace Tests\Feature;

use App\Services\ReservationRefund;
use Carbon\Carbon;
use Tests\TestCase;

class RefundPolicyTest extends TestCase
{
    public function test_full_refund_at_48_hours_or_more(): void
    {
        $now = Carbon::parse('2026-11-01 10:00', 'Asia/Manila');
        $this->assertTrue(ReservationRefund::isFullRefund($now->copy()->addHours(48), $now));
        $this->assertTrue(ReservationRefund::isFullRefund($now->copy()->addDays(5), $now));
    }

    public function test_no_refund_under_48_hours(): void
    {
        $now = Carbon::parse('2026-11-01 10:00', 'Asia/Manila');
        $this->assertFalse(ReservationRefund::isFullRefund($now->copy()->addHours(47), $now));
        $this->assertFalse(ReservationRefund::isFullRefund($now->copy()->subHour(), $now));
    }
}