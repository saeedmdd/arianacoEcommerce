<?php


return [
    "sms-driver" => env("SMS_SERVICE", 'kavenegar'),
    "kavenegar" => [
        "key" => env("KAVENEGAR_API_KEY")
    ],
    "melli-payamak" => [
        "key" => env("MELLI_PAYAMAK_API_KEY")
    ]
];
