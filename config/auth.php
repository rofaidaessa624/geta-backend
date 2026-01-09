<?php

return [

    'defaults' => [
        'guard' => 'admin-api',
        'passwords' => 'admins',
    ],

    'guards' => [

        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'admin-api' => [
            'driver' => 'token',       // ✅ token driver (api_token)
            'provider' => 'admins',
            'hash' => false,
        ],
    ],

    'providers' => [

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminUser::class,
        ],

    ],

    'passwords' => [

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

    ],

    'password_timeout' => 10800,

];
