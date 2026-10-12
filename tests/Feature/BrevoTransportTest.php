<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class BrevoTransportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'mail.default' => 'brevo',
            'mail.mailers.brevo' => ['transport' => 'brevo', 'key' => 'test-key'],
            'mail.from' => ['address' => 'sender@example.com', 'name' => 'StaySwift'],
        ]);
        Mail::purge('brevo');
    }

    public function test_sends_email_through_brevo_api(): void
    {
        Http::fake(['api.brevo.com/*' => Http::response(['messageId' => '<abc>'], 201)]);

        Mail::raw('Hello', fn ($m) => $m->to('user@example.com')->subject('Hi'));

        Http::assertSent(fn ($request) => $request->url() === 'https://api.brevo.com/v3/smtp/email'
            && $request->hasHeader('api-key', 'test-key')
            && $request['sender']['email'] === 'sender@example.com'
            && $request['to'][0]['email'] === 'user@example.com'
            && $request['subject'] === 'Hi'
            && $request['textContent'] === 'Hello');
    }

    public function test_throws_when_brevo_rejects_the_request(): void
    {
        Http::fake(['api.brevo.com/*' => Http::response(['message' => 'Sender not valid'], 400)]);

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('Sender not valid');

        Mail::raw('Hello', fn ($m) => $m->to('user@example.com')->subject('Hi'));
    }

    public function test_throws_when_api_key_is_missing(): void
    {
        config(['mail.mailers.brevo' => ['transport' => 'brevo', 'key' => null]]);
        Mail::purge('brevo');
        Http::fake();

        $this->expectException(TransportException::class);

        Mail::raw('Hello', fn ($m) => $m->to('user@example.com')->subject('Hi'));
    }
}