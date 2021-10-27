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

    'mailgun'  => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses'      => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google'   => [
        'client_id'     => '475867216933-bj4oj9c4qoc6u8btob7rg7409eumv0tr.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect'      => 'http://localhost:8000/auth/google/callback',
    ],
    'facebook' => [
        'client_id'     => '1184181885409366',
        'client_secret' => 'c7da528059bab23f5e3b6ff5d33b6b24',
        'redirect'      => 'http://127.0.0.1:8000/auth/facebook/callback',
    ],

];
