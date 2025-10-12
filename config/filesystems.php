<?php

return [

    'default' => env('FILESYSTEM_DISK', 'cloudinary'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        // ✅ Cloudinary Disk Configuration
        'cloudinary' => [
            'driver' => 'cloudinary',
            'cloud'  => env('CLOUDINARY_CLOUD_NAME'),
            'key'    => env('CLOUDINARY_API_KEY'),
            'secret' => env('CLOUDINARY_API_SECRET'),
            'secure' => true,
        ],
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
