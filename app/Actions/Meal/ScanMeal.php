<?php

namespace App\Actions\Meal;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ScanMeal
{
    private string $baseURL;
    private string $apiKey;

    public function __construct()
    {
        $this->baseURL = config('foodvisor.base_url');
        $this->apiKey = config('foodvisor.api_key');
    }

    /**
     * @throws ConnectionException
     */
    public function execute(array $image): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $endpoint = $this->baseURL . "/analysis";

        $scopes = [
            'multiple_items',
            'position'
        ];

        $headers = [
            'Authorization' => 'Api-Key ' . $this->apiKey,
        ];

        $data = [];
        foreach ($scopes as $scope) {
            $data[] = [
                'name' => 'scopes[]',
                'contents' => $scope
            ];
        }

        return Http::withHeaders($headers)
            ->attach('image', fopen($image['file'], 'r'), 'image.' . $image['type'])
            ->post($endpoint, $data);
    }
}
