<?php

namespace App\Actions\Meal;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SearchMeal
{
    private string $baseURL;
    private string $appId;
    private string $appKey;

    public function __construct()
    {
        $this->appId = config('edamam.recipe.app_id');
        $this->appKey = config('edamam.recipe.app_key');
        $this->baseURL = config('edamam.base_url');
    }

    /**
     * @throws ConnectionException
     */
    public function execute(string $query, string|null $nextPageKey = null): Response
    {
        $endpoint = $this->baseURL . "/api/recipes/v2";
        $headers = [
            'Accept-Encoding' => 'gzip',
//            'Edamam-Account-User' => Auth::user()->anon_id
        ];
        $data = [
            'q' => $query,
            'type' => 'public',
            'app_id' => $this->appId,
            'app_key' => $this->appKey,
        ];

        if ($nextPageKey) {
            $data['_cont'] = $nextPageKey;
        }

        $query = http_build_query($data);

        return Http::withHeaders($headers)->withOptions([
            'decode_content' => 'gzip'
        ])->get($endpoint . '?' . $query);
//        return Http::get($endpoint . '?' . $query);
    }
}
