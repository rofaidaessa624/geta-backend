<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | ✅ أضفنا:
    | - api (sanctum) للمستخدمين العاديين لو احتجتي
    | - admin-api (sanctum) للأدمن dashboard
    */
    'guards' => [

        // ✅ Web Guard (Session)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // ✅ API Guard (Sanctum)
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],

        // ✅ Admin API Guard (Sanctum)
        'admin-api' => [
            'driver' => 'sanctum',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | ✅ عندك users + admins
    */
    'providers' => [

        // ✅ Default Users (لو عندك users table في المستقبل)
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // ✅ Admin Users (Dashboard)
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminUser::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | ✅ هنا هنضيف reset خاص بالأدمن كمان
    */
    'passwords' => [

        // ✅ Users Reset (لو عندك users)
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // ✅ Admin Reset
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];
