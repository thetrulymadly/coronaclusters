<?php

return [
    'speqtra' => [
        'url' => 'http://sms.speqtrainnov.com/api/v4/',
        'api_key' => env('SPEQTRA_API_KEY', ''),
        'method' => 'sms',
        'sender' => 'PLSMAM',
    ],

    'format' => [
        'otp' => env('SMS_OTP_FORMAT', ''),
    ],
];