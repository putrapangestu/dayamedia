<?php

return [
    'base_url' => env('WHATSAPP_BASE_URL', 'https://wa.hummatech.com/send-message'),
    'api_key' => env('WHATSAPP_API_KEY', null),
    'sender' => env('WHATSAPP_SENDER', null),
    'dispatch_delay' => env('WHATSAPP_DISPATCH_DELAY', 3),
    'min_gap_seconds' => env('WHATSAPP_MIN_GAP_SECONDS', 5),
];
