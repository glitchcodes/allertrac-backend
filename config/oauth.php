<?php

return [
    /**
     * ---------------------------------------------------------------------
     * OAuth Configuration
     * ---------------------------------------------------------------------
     *
     * This configuration is used to configure the OAuth providers that you want to use in your application
     */
    'providers' => [
        'google' => [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'scopes' => [
                'profile',
                'email'
            ]
        ],
//        'facebook' => [
//            'client_id' => env('FACEBOOK_CLIENT_ID'),
//            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
//            'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
//            'scopes' => [
//                'email'
//            ]
//        ]
    ]
];
