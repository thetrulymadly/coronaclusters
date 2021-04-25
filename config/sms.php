<?php

return [
    'speqtra' => [
        'url' => 'http://sms.speqtrainnov.com/api/v4/',
        'api_key' => env('SPEQTRA_API_KEY', 'A72dda1193d946887d7451aafd25830f9'),
        'method' => 'sms',
        'sender' => 'TRMDLY',
    ],

    'format' => [
        'otp' => env('SMS_OTP_FORMAT', '{#var#} Your TrulyMadly OTP code is: {#var#}. Do not disclose it to anyone. ozu+gXsvkHi'),
    ],
    "android_hash" => env('ANDROID_HASH', "ozu+gXsvkHi"),
];