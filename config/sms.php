<?php
/**
 * SMS Configuration
 *
 * Integration with Textbelt API
 * Get your API key from https://textbelt.com/
 */

return [
    'textbelt' => [
        'api_key' => env('TEXTBELT_API_KEY', ''),
    ],

    'oneway' => [
        'api_username' => env('ONEWAY_API_USERNAME', ''),
        'api_password' => env('ONEWAY_API_PASSWORD', ''),
        'sender_id' => env('ONEWAY_SENDER_ID', ''),
    ],
];
