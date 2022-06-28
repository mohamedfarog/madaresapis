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
    'facebook' => [
        'client_id' => '1366944950493153',
        'client_secret' => 'a0390f05218397a8ce360cdd13fcb1f3',
        'redirect' => '',
    ],
    'google' => [
        'client_id' => '22469777881-nvmqpej13dc8mlpid7269r6la3lg4o9k.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => '',
    ],

    'linkedin' => [
        'client_id' => '77yk50w1lur7e3',
        'client_secret' => 'ZFTJW0BFZTpyonZv',
        'redirect' => '',
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
