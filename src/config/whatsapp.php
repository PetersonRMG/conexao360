<?php

return [
    // disabled | log (somente em APP_ENV=local) | meta
    'driver' => env('WHATSAPP_DRIVER', 'disabled'),
    'graph_version' => env('WHATSAPP_GRAPH_VERSION', 'v26.0'),
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
    'template_name' => env('WHATSAPP_TEMPLATE_NAME', 'codigo_verificacao'),
    'template_language' => env('WHATSAPP_TEMPLATE_LANGUAGE', 'pt_BR'),
];
