<?php

return [
    'default' => env('FILESYSTEM_DISK', 'public'),
    'disks' => [
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', ''), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],
    ],
];
