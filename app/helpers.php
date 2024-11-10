<?php

if (!function_exists('validateGoogleToken')) {
    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    function validateGoogleToken(string $token): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $endpoint = 'https://www.googleapis.com/oauth2/v3/tokeninfo';

        $headers = [
            'Accept' => 'application/json'
        ];

        // Encode the data
        $data = [
            'access_token' => $token
        ];

        $query = http_build_query($data);

        return \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->get($endpoint . '?' . $query);
    }
}

if (!function_exists('validateOAuthProvider')) {
    /**
     * Validate the token with the OAuth provider
     *
     * @param string $provider
     * @param array $credentials
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws Exception
     */
    function validateOAuthProvider(string $provider, array $credentials): array
    {
        if ($provider === 'google') {
            $response = validateGoogleToken($credentials['access_token']);

            if (isset($response['sub'])) {
                return [
                    'provider_id' => $response['sub'],
                ];
            } else {
                throw new Exception('Invalid Google ID token.');
            }
        } else if ($provider === 'twitter') {
            // TODO: Implement Twitter/X
            throw new Exception('Twitter/X is not implemented.');
        } else if ($provider === 'facebook') {
            // TODO: Implement Facebook
            throw new Exception('Facebook is not implemented.');
        }

        return [];
    }
}
