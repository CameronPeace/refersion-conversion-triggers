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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'shopify' => [
        'key' => env('SHOPIFY_API_KEY'),
        'password' => env('SHOPIFY_API_PASS'),
        'sign' => env('SHOPIFY_WEBHOOK_SIGN'),
        'domain' => env('SHOPIFY_WEBHOOK_DOMAIN')
    ],

    'refersion' => [
        'public' => env('REFERSION_PUBLIC_API_KEY'),
        'secret' => env('REFERSION_SECRET_API_KEY'),
        'base' => env('REFERSION_API_BASE')
    ]

];
