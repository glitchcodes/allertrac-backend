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

            'web' => [
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            ],
            'android' => [
                'client_id' => env('GOOGLE_ANDROID_CLIENT_ID'),
            ],
            'ios' => [
                'client_id' => env('GOOGLE_IOS_CLIENT_ID'),
            ],
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
