<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud\Controllers;

use Dskripchenko\LaravelApi\Components\ApiException;
use Dskripchenko\LaravelApi\Controllers\CrudController;
use Dskripchenko\LaravelApiUser\Api\Crud\Services\CrudUserService;
use Dskripchenko\LaravelApiUser\Requests\RequestWithRoles;
use Illuminate\Http\JsonResponse;

/**
 * Class CrudUserController
 * @package Dskripchenko\LaravelApiUser\Api\Crud\Controllers
 */
class CrudUserController extends CrudController
{
    /**
     * CrudUserController constructor.
     * @param CrudUserService $crudService
     */
    public function __construct(CrudUserService $crudService)
    {
        parent::__construct($crudService);
    }

    /**
     * Установить роли для пользователя
     *
     * @input integer $id Уникальный идентификатор пользователя
     * @input string $roleIds Идентификаторы ролей разделенных запятой (1,2,3,4)
     *
     * @param RequestWithRoles $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function setRoles(RequestWithRoles $request, int $id): JsonResponse
    {
        return $this->success($this->crudService->setRoles($id, $request->getRoles()));
    }
}
