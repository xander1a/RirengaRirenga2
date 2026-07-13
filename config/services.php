<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'momo' => [
        'base_url'                    => env('MOMO_BASE_URL', 'https://sandbox.momodeveloper.mtn.com'),
        'collection_subscription_key' => env('MOMO_COLLECTION_SUBSCRIPTION_KEY'),
        'collection_user_id'          => env('MOMO_COLLECTION_USER_ID'),
        'collection_api_key'          => env('MOMO_COLLECTION_API_KEY'),
        'environment'                 => env('MOMO_ENVIRONMENT', 'sandbox'),
        'currency'                    => env('MOMO_CURRENCY', 'RWF'),
        'callback_url'                => env('MOMO_CALLBACK_URL'),
    ],

    'flutterwave' => [
        'public_key'     => env('FLUTTERWAVE_PUBLIC_KEY'),
        'secret_key'     => env('FLUTTERWAVE_SECRET_KEY'),
        'webhook_secret' => env('FLUTTERWAVE_WEBHOOK_SECRET'),
    ],

    'paypack' => [
        'client_id'     => env('PAYPACK_CLIENT_ID'),
        'client_secret' => env('PAYPACK_CLIENT_SECRET'),
        'webhook_mode'  => env('PAYPACK_WEBHOOK_MODE', 'development'),
    ],

];
