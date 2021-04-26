<?php

return [
    'speqtra' => [
        'url' => env('SPEQTRA_API_URL', ''),
        'api_key' => env('SPEQTRA_API_KEY', ''),
        'method' => 'sms',
        'sender' => env('SPEQTRA_SENDER', ''),
    ],

    'format' => [
        'otp' => env('SMS_OTP_FORMAT', ''),
    ],
];