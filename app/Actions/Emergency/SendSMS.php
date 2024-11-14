<?php

namespace App\Actions\Emergency;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSMS
{
    private string $apiKey;
    private string $apiEndpoint = 'https://textbelt.com/text';

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->apiKey = config('sms.api_key', '');

        if (empty($this->apiKey)) {
            throw new Exception('SMS API Key is not set. Aborting...');
        }

//        if (config('app.env') !== 'production') {
//            $this->apiKey = $this->apiKey . '_test';
//        }
    }

    /**
     * @throws Exception
     */
    public function execute(string $phoneNumber, string $message): array
    {
        $response = Http::post($this->apiEndpoint, [
            'phone' => $phoneNumber,
            'message' => $message,
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            Log::error('Failed to send SMS', [
                'response' => $response->json(),
            ]);

            throw new Exception('Failed to send SMS');
        }

        return $response->json();
    }
}
