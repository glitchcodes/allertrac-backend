<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        '/*',
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => ['*'],

    // See https://ionicframework.com/docs/troubleshooting/cors#capacitor
    'allowed_origins' => [
        'capacitor://localhost', // For iOS
        'http://localhost', // For Android
        'http://localhost:8100' // For development
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
