<?php

return [
    'sms' => [
        'api_key' => env('SMS_API_KEY', '7c3f60449a680a835b7670470a60c48974fc0a9a9fa88a33fb05b574042a7c90'),
        'from' => env('SMS_FROM', '+14089097717'),
        'email' => env('SMS_EMAIL', 'team@codewithus.com'),
        'url' => env('SMS_URL', 'https://api.toky.co/v1/sms/send'),
        'method' => env('SMS_METHOD', 'POST'),
    ],

    'passport' => [
        'grant_type' => env('GRANT_TYPE', 'password'),
        'client_id' => env('CLIENT_ID', 2),
        'client_secret' => env('CLIENT_SECRET', '870iTNHowoeaEDnL5PbH3LLyYm3yAjugioUAQ3Bq'),
        'scope' => env('SCOPE', '*'),
    ],

];