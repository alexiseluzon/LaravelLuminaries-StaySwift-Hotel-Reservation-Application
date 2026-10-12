<?php

namespace App\Mail;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

/**
 * Sends mail through Brevo's HTTPS API (port 443).
 * Used instead of SMTP because Render free web services block ports 25/465/587.
 */
class BrevoTransport extends AbstractTransport
{
    private const ENDPOINT = 'https://api.brevo.com/v3/smtp/email';

    public function __construct(private readonly ?string $apiKey)
    {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        if (empty($this->apiKey)) {
            throw new TransportException('Brevo API key is not configured (BREVO_API_KEY).');
        }

        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $from = $email->getFrom()[0] ?? null;
        $html = $email->getHtmlBody();
        $text = $email->getTextBody();

        if ($from === null || $email->getTo() === []) {
            throw new TransportException('Brevo: message needs a sender and at least one recipient.');
        }
        if ($html === null && $text === null) {
            throw new TransportException('Brevo: message has no content.');
        }

        $payload = array_filter([
            'sender' => $this->contact($from),
            'to' => array_map([$this, 'contact'], $email->getTo()),
            'cc' => array_map([$this, 'contact'], $email->getCc()),
            'bcc' => array_map([$this, 'contact'], $email->getBcc()),
            'replyTo' => isset($email->getReplyTo()[0]) ? $this->contact($email->getReplyTo()[0]) : null,
            'subject' => $email->getSubject() ?? '',
            'htmlContent' => is_resource($html) ? stream_get_contents($html) : $html,
            'textContent' => is_resource($text) ? stream_get_contents($text) : $text,
        ], fn ($value) => $value !== null && $value !== []);

        try {
            $response = Http::withHeaders(['api-key' => $this->apiKey])
                ->acceptJson()
                ->asJson()
                ->timeout(10)
                ->retry(2, 300, fn ($e) => $e instanceof ConnectionException, throw: false)
                ->post(self::ENDPOINT, $payload);
        } catch (ConnectionException $e) {
            throw new TransportException('Brevo: could not reach the API. ' . $e->getMessage(), 0, $e);
        }

        if ($response->failed()) {
            throw new TransportException(sprintf(
                'Brevo API error (HTTP %d): %s',
                $response->status(),
                $response->json('message') ?? substr($response->body(), 0, 200)
            ));
        }
    }

    private function contact(Address $address): array
    {
        return array_filter([
            'email' => $address->getAddress(),
            'name' => $address->getName() ?: null,
        ]);
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}