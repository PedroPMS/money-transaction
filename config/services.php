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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'transaction_autorizer' => [
        'base_url' => env('TRANSACTION_AUTORIZER_BASE_URL', 'https://run.mocky.io/v3/'),
        'autorizer_url' => env('TRANSACTION_AUTORIZER_URL', '8fafdd68-a090-496f-8c9a-3442cf30dae6'),
        'autorized_message' => env('TRANSACTION_AUTORIZED_MESSAGE', 'Autorizado'),
    ],

    'transaction_notifier' => [
        'base_url' => env('TRANSACTION_NOTIFIER_BASE_URL', 'http://o4d9z.mocklab.io/'),
        'notify_url' => env('TRANSACTION_NOTIFIER_URL', 'notify'),
        'success_message' => env('TRANSACTION_NOTIFIER_MESSAGE', 'Success'),
    ],

];
