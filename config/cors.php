<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // Local development
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'http://192.168.56.1:3000',

        // Frontend hosting (example)
        'https://learnoria-frontend.vercel.app',

        // (اختياري) لو عندك نسخة Frontend على Railway أو مكان تاني ضيفها هنا:
        // 'https://learnoria-frontend-production.up.railway.app',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // فقط اجعلها true لو بتستخدم الـ cookies / session auth عبر الـ browser (sanctum)
    // 'supports_credentials' => false,
    'supports_credentials' => true,

];
