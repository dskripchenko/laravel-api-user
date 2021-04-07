<?php

use \Dskripchenko\LaravelApiUser\Models\User;

return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => User::class
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
            'connection' => env('DB_LAYER_CONNECTION', 'layer')
        ],
    ],

    'password_timeout' => 10800,

];
