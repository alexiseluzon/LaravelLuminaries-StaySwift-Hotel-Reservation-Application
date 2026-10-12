<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ResendVerificationTest extends TestCase
{
    public function test_rejects_an_invalid_email(): void
    {
        $this->postJson('/resendVerification', ['email' => 'not-an-email'])
            ->assertStatus(422);
    }

    public function test_second_request_within_cooldown_is_rejected(): void
    {
        Cache::put('resend-verify:' . sha1('juan@email.com'), 1, 60);

        $this->postJson('/resendVerification', ['email' => 'Juan@Email.com'])
            ->assertStatus(429)
            ->assertJson(['status' => 'wait']);
    }
}