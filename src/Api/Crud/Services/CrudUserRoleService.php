<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud\Services;

use Dskripchenko\LaravelApi\Components\Meta;
use Dskripchenko\LaravelApi\Resources\BaseJsonResource;
use Dskripchenko\LaravelApi\Resources\BaseJsonResourceCollection;
use Dskripchenko\LaravelApi\Services\CrudService;
use Dskripchenko\LaravelApiUser\Models\UserRole;
use Dskripchenko\LaravelApiUser\Resources\UserRoleResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CrudUserRoleService
 * @package Dskripchenko\LaravelApiUser\Api\Crud\Services
 */
class CrudUserRoleService extends CrudService
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
        return UserRole::query();
    }

    /**
     * @param Model $model
     * @return BaseJsonResource
     */
    public function resource(Model $model): BaseJsonResource
    {
        return (new UserRoleResource($model))->withPermissions();
    }

    /**
     * @param Collection $collection
     * @return BaseJsonResourceCollection
     */
    public function collection(Collection $collection): BaseJsonResourceCollection
    {
        return UserRoleResource::collection($collection);
    }

    /**
     * @param int $id
     * @param Collection $permissions
     * @return BaseJsonResource
     */
    public function setPermission(int $id, Collection $permissions): BaseJsonResource
    {
        $userRole = UserRole::query()->findOrFail($id);
        $userRole->setPermissions($permissions);

        return $this->resource($userRole);
    }
}
