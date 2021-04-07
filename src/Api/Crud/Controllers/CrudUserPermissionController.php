<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud\Controllers;

use Dskripchenko\LaravelApi\Controllers\CrudController;
use Dskripchenko\LaravelApiUser\Api\Crud\Services\CrudUserPermissionService;

/**
 * Class CrudUserPermissionController
 * @package Dskripchenko\LaravelApiUser\Api\Crud\Controllers
 */
class CrudUserPermissionController extends CrudController
{
    /**
     * CrudUserPermissionController constructor.
     * @param CrudUserPermissionService $crudService
     */
    public function __construct(CrudUserPermissionService $crudService)
    {
        parent::__construct($crudService);
    }
}
