<?php

namespace Dskripchenko\LaravelApiUser\Api\App;

use Dskripchenko\LaravelApi\Components\BaseApi;
use Dskripchenko\LaravelApiUser\Api\App\Controllers\UserController;
use Dskripchenko\LaravelApiUser\Middlewares\UseMainLayerConnection;
use Dskripchenko\LaravelApiUser\Middlewares\OnlyAuth;

/**
 * Class Api
 * @package Dskripchenko\LaravelApiUser\Api\App
 */
class Api extends BaseApi
{
    /**
     * @return array
     */
    public static function getMethods(): array
    {
        return [
            'controllers' => [
                'user' => [
                    'controller' => UserController::class,
                    'actions' => [
                        'info',
                        'register' => [
                            'exclude-middleware' => [
                                OnlyAuth::class
                            ]
                        ],
                        'login' => [
                            'exclude-middleware' => [
                                OnlyAuth::class
                            ]
                        ],
                        'password-reset' => [
                            'action' => 'passwordReset',
                            'exclude-middleware' => [
                                OnlyAuth::class
                            ]
                        ],
                        'password-set' => [
                            'action' => 'passwordSet',
                            'exclude-middleware' => [
                                OnlyAuth::class
                            ]
                        ],
                        'password-change' => 'passwordChange',
                        'logout',
                    ]
                ]
            ],
            'middleware' => [
                OnlyAuth::class,
                UseMainLayerConnection::class
            ]
        ];
    }
}
