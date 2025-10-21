<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    /**
     * Send a simple transactional email via Brevo API.
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $subject
     * @param string $htmlContent
     * @param array|null $replyTo ['email'=>'x','name'=>'y'] optional
     * @return array ['ok' => bool, 'message' => string]
     */
    public static function send(string $toEmail, string $toName, string $subject, string $htmlContent, array $replyTo = null): array
    {
        $apiKey = env('MAIL_PASSWORD');

        if (!$apiKey) {
            Log::error('Brevo API key not set');
            return ['ok' => false, 'message' => 'Brevo API key not configured'];
        }

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);

        $apiInstance = new TransactionalEmailsApi(
            new Client(), // Guzzle client
            $config
        );

        $sender = [
            'email' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME') ?? 'Learnoria'
        ];

        $to = [
            [
                'email' => $toEmail,
                'name' => $toName,
            ],
        ];

        $payload = new SendSmtpEmail([
            'subject' => $subject,
            'sender' => $sender,
            'to' => $to,
            'htmlContent' => $htmlContent,
        ]);

        if ($replyTo && isset($replyTo['email'])) {
            $payload->setReplyTo(['email' => $replyTo['email'], 'name' => $replyTo['name'] ?? null]);
        }

        try {
            $response = $apiInstance->sendTransacEmail($payload);
            // Brevo returns an object - log id/info if needed
            Log::info('Brevo send success', ['response' => json_decode(json_encode($response), true)]);
            return ['ok' => true, 'message' => 'Sent'];
        } catch (\Throwable $e) {
            Log::error('Brevo send failed: ' . $e->getMessage(), [
                'exception' => (string) $e,
            ]);
            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }
}
