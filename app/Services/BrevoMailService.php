<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

class BrevoMailService
{
    public static function send($to, $subject, $htmlContent)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));
        $apiInstance = new TransactionalEmailsApi(null, $config);

        $email = new SendSmtpEmail([
            'subject' => $subject,
            'sender' => ['email' => env('MAIL_FROM_ADDRESS'), 'name' => env('MAIL_FROM_NAME')],
            'to' => [['email' => $to]],
            'htmlContent' => $htmlContent,
        ]);

        try {
            $result = $apiInstance->sendTransacEmail($email);
            return $result;
        } catch (\Exception $e) {
            \Log::error('Brevo email failed: '.$e->getMessage());
            return false;
        }
    }
}
