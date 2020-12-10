<?php

return [
    'app' => [
        'name' => env('API_APP_NAME', 'App Name'),
        'url' => env('API_APP_URL', 'http://appname'),
        'urls' => [
            'user' => [
                'password' => [
                    'reset' => env('API_APP_URLS_USER_PASSWORD_RESET', 'password/reset'),
                    'set' => env('API_APP_URLS_USER_PASSWORD_SET', 'password/set'),
                ],
            ],
        ]
    ],

];
