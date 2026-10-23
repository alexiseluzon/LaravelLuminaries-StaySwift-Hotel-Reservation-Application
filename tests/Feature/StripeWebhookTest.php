<?php

namespace Tests\Feature;

use Tests\TestCase;

class StripeWebhookTest extends TestCase
{
    public function test_rejects_bad_signature(): void
    {
        config(['stripe.webhook_secret' => 'whsec_test']);

        $this->call('POST', '/stripe/webhook', [], [], [], [
            'HTTP_STRIPE_SIGNATURE' => 't=1,v1=bad',
            'CONTENT_TYPE' => 'application/json',
        ], '{"type":"checkout.session.completed"}')->assertStatus(400);
    }

    public function test_rejects_when_secret_missing(): void
    {
        config(['stripe.webhook_secret' => null]);

        $this->postJson('/stripe/webhook', [])->assertStatus(400);
    }
}