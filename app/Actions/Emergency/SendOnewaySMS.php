<?php

namespace App\Actions\Emergency;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SendOnewaySMS
{
    private string $apiEndpoint = 'https://sgateway.onewaysms.com/apis10.aspx';
    private string $apiUsername;
    private string $apiPassword;
    private string $senderId;

    public function __construct()
    {
        $this->apiUsername = config('sms.oneway.api_username', '');
        $this->apiPassword = config('sms.oneway.api_password', '');
        $this->senderId = config('sms.oneway.sender_id', '');
    }

    public function execute(string $phoneNumber, string $message): Response
    {
        if (str_starts_with($phoneNumber, '+')) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        $queries = http_build_query([
            'apiusername' => $this->apiUsername,
            'apipassword' => $this->apiPassword,
            'senderid' => $this->senderId,
            'mobileno' => $phoneNumber,
            'message' => $message,
            'languagetype' => 1,
        ]);

        $url = $this->apiEndpoint . '?' . $queries;

        return Http::get($url);
    }
}
