<?php

namespace App\Actions\Emergency;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSemaphoreSMS
{
    private string $apiKey;
    private string $senderName;
    private string $apiEndpoint = 'https://api.semaphore.co/api/v4/messages';

    /**
     * Initialize Semaphore
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->apiKey = config('sms.semaphore.api_key', '');
        $this->senderName = config('sms.semaphore.sender_name', 'DNLRefills');

        if (empty($this->apiKey)) {
            throw new Exception('SMS API Key is not set. Aborting...');
        }
    }

    /**
     * @throws Exception
     */
    public function execute(string $phoneNumber, string $message): array
    {
        $response = Http::post($this->apiEndpoint, [
            'apikey' => $this->apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sendername' => $this->senderName
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
