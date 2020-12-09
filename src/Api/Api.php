<?php

namespace Dskripchenko\LaravelApiUser\Api;

use Dskripchenko\LaravelApiUser\Api\Controllers\UserController;

class Api extends \Dskripchenko\LaravelApi\Components\BaseApi
{
    protected static function getMethods()
    {
        return [
            'controllers' => [
                'user' => [
                    'controller' => UserController::class,
                    'actions' => [
                        'info',
                        'register',
                        'login',
                        'password-reset' => 'passwordReset',
                        'password-set' => 'passwordSet',
                        'password-change' => 'passwordChange',
                        'logout',
                    ]
                ]
            ]
        ];
    }
}
