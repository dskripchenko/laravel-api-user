<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud;

use Dskripchenko\LaravelApi\Components\BaseApi;
use Dskripchenko\LaravelApiUser\Api\Crud\Controllers\CrudUserController;
use Dskripchenko\LaravelApiUser\Api\Crud\Controllers\CrudUserPermissionController;
use Dskripchenko\LaravelApiUser\Api\Crud\Controllers\CrudUserRoleController;

/**
 * Class Api
 * @package Dskripchenko\LaravelApiUser\Api\Crud
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
                    'controller' => CrudUserController::class,
                    'actions' => [
                        'meta' => [],
                        'search' => ['middleware' => ['can:user.read']],
                        'create' => ['middleware' => ['can:user.create']],
                        'read' => ['middleware' => ['can:user.read']],
                        'update' => ['middleware' => ['can:user.update']],
                        'set-roles' => [
                            'middleware' => ['can:user.update', 'can:role.read'],
                            'action' => 'setRoles'
                        ],
                        'delete' => ['middleware' => ['can:user.delete']],
                    ]
                ],
                'user-permission' => [
                    'controller' => CrudUserPermissionController::class,
                    'actions' => [
                        'meta' => [],
                        'search' => ['middleware' => ['can:permission.read']],
                        'create' => ['middleware' => ['can:permission.create']],
                        'read' => ['middleware' => ['can:permission.read']],
                        'update' => ['middleware' => ['can:permission.update']],
                        'delete' => ['middleware' => ['can:permission.delete']],
                    ],
                ],
                'user-role' => [
                    'controller' => CrudUserRoleController::class,
                    'actions' => [
                        'meta' => [],
                        'search' => ['middleware' => ['can:role.read']],
                        'create' => ['middleware' => ['can:role.create']],
                        'read' => ['middleware' => ['can:role.read']],
                        'update' => ['middleware' => ['can:role.update']],
                        'set-permissions' => [
                            'middleware' => ['can:role.update', 'can:permission.read'],
                            'action' => 'setPermissions'
                        ],
                        'delete' => ['middleware' => ['can:role.delete']],
                    ],
                ],
            ]
        ];
    }
}
