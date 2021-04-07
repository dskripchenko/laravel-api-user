<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud\Services;

use Dskripchenko\LaravelApi\Components\Meta;
use Dskripchenko\LaravelApi\Resources\BaseJsonResource;
use Dskripchenko\LaravelApi\Resources\BaseJsonResourceCollection;
use Dskripchenko\LaravelApi\Services\CrudService;
use Dskripchenko\LaravelApiUser\Models\UserPermission;
use Dskripchenko\LaravelApiUser\Resources\UserPermissionResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CrudUserPermissionService
 * @package Dskripchenko\LaravelApiUser\Api\Crud\Services
 */
class CrudUserPermissionService extends CrudService
{

    /**
     * @return Meta
     */
    public function meta(): Meta
    {
        return (new Meta())
            ->hidden('id', 'Id')
            ->string('key', 'Key')
            ->string('name', 'Name')
            ->string('group', 'Group')
            ->create(can('role.create'))
            ->read(can('role.read'))
            ->update(can('role.update'))
            ->delete(can('role.delete'));
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return UserPermission::query();
    }

    /**
     * @param Model $model
     * @return BaseJsonResource
     */
    public function resource(Model $model): BaseJsonResource
    {
        return new UserPermissionResource($model);
    }

    /**
     * @param Collection $collection
     * @return BaseJsonResourceCollection
     */
    public function collection(Collection $collection): BaseJsonResourceCollection
    {
        return UserPermissionResource::collection($collection);
    }
}
