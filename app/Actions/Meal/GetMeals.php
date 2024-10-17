<?php

namespace App\Actions\Meal;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetMeals
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
    public function execute(array $uri): Response
    {
        $endpoint = $this->baseURL . "/api/recipes/v2/by-uri";
        $headers = [
            'Accept-Encoding' => 'gzip',
//            'Edamam-Account-User' => Auth::user()->anon_id
        ];
        $data = [
            'type' => 'public',
            'uri' => $uri,
            'app_id' => $this->appId,
            'app_key' => $this->appKey,
        ];

        $query = $this->custom_build_query($data);

        Log::info($query);

        return Http::withHeaders($headers)->withOptions([
            'decode_content' => 'gzip'
        ])->get($endpoint . '?' . $query);
//        return Http::get($endpoint . '?' . $query);
    }

    // https://stackoverflow.com/a/43618068/16887875
    private function custom_build_query(
        array|object $query_data,
        string $numeric_prefix = "",
        ?string $arg_separator = null,
        int $encoding_type = PHP_QUERY_RFC1738
    ): string {
        // Cast to array if object is supplied.
        $query_data = is_object($query_data) ? get_object_vars($query_data) : $query_data;

        // Use supplied arg_separator value, defaulting to the `arg_separator.output` php configuration.
        $arg_separator = $arg_separator ?? ini_get("arg_separator.output");

        // If PHP_QUERY_RFC3986 is specified, use rawurlencode to encode parameters.
        $encoding_function = $encoding_type === PHP_QUERY_RFC3986 ? "rawurlencode" : "urlencode";

        $query = [];
        foreach ($query_data as $name => $value) {
            $value = (array) $value;
            $name = is_int($name) ? $numeric_prefix . $name : $name;
            array_walk_recursive($value, function ($value) use (&$query, $name, $encoding_function) {
                $query[] = $encoding_function($name) . "=" . $encoding_function($value);
            });
        }
        return implode($arg_separator, $query);
    }
}
