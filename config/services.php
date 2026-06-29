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

    'tripay' => [
        'mode'         => 'production',
        'merchant_code' => env('TRIPAY_MERCHANT_CODE_PROD'),
        'api_key'       => env('TRIPAY_API_KEY_PROD'),
        'private_key'   => env('TRIPAY_PRIVATE_KEY_PROD'),
        'base_url'      => env('TRIPAY_PRODUCTION_BASEURL'),
        'callback_url'  => env('TRIPAY_CALLBACK_URL_PROD'),
    ],



];
