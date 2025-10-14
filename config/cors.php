<?php

return [

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3000',
    'https://localhost:3000', 
    'https://learnoria-frontend-production.up.railway.app',
    'allowed_origins' => [
        'http://localhost:3000',
        'http://192.168.56.1:3000',
        'https://learnoria-frontend.vercel.app',
    ],
],


    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
