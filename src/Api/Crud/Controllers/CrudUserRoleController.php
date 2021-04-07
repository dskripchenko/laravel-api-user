<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud\Controllers;

use Dskripchenko\LaravelApi\Controllers\CrudController;
use Dskripchenko\LaravelApi\Exceptions\ApiException;
use Dskripchenko\LaravelApiUser\Api\Crud\Services\CrudUserRoleService;
use Dskripchenko\LaravelApiUser\Requests\RequestWithPermissions;
use Illuminate\Http\JsonResponse;

/**
 * Class CrudUserRoleController
 * @package Dskripchenko\LaravelApiUser\Api\Crud\Controllers
 */
class CrudUserRoleController extends CrudController
{
    /**
     * @var CrudUserRoleService
     */
    protected $crudService;

    /**
     * CrudUserRoleController constructor.
     * @param CrudUserRoleService $crudService
     */
    public function __construct(CrudUserRoleService $crudService)
    {
        parent::__construct($crudService);
    }

    /**
     * Установить функциональные разрешения для роли
     *
     * @input integer $id Уникальный идентификатор роли
     * @input string $permissionIds Идентификаторы функциональных разрешений разделенных запятой (1,2,3,4)
     *
     * @param RequestWithPermissions $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function setPermissions(RequestWithPermissions $request, int $id): JsonResponse
    {
        return $this->success($this->crudService->setPermission($id, $request->getPermissions()));
    }
}
