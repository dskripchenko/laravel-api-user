<?php

namespace Dskripchenko\LaravelApiUser\Api\Crud\Services;

use Dskripchenko\LaravelApi\Components\Meta;
use Dskripchenko\LaravelApi\Resources\BaseJsonResource;
use Dskripchenko\LaravelApi\Resources\BaseJsonResourceCollection;
use Dskripchenko\LaravelApi\Services\CrudService;
use Dskripchenko\LaravelApiUser\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Dskripchenko\LaravelApiUser\Resources\UserResource;

/**
 * Class CrudUserService
 * @package Dskripchenko\LaravelApiUser\Api\Crud\Services
 */
class CrudUserService extends CrudService
{
    /**
     * @return Meta
     */
    public function meta(): Meta
    {
        return (new Meta())
            ->hidden('id', 'Id')
            ->string('name', 'Name')
            ->string('email', 'Email')
            ->create(can('user.create'))
            ->read(can('user.read'))
            ->update(can('user.update'))
            ->delete(can('user.delete'));

    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return User::query();
    }

    /**
     * @param Model $model
     * @return BaseJsonResource
     */
    public function resource(Model $model): BaseJsonResource
    {
        return new UserResource($model);
    }

    /**
     * @param Collection $collection
     * @return BaseJsonResourceCollection
     */
    public function collection(Collection $collection): BaseJsonResourceCollection
    {
        return UserResource::collection($collection);
    }


    /**
     * @param int $id
     * @param Collection $roles
     * @return BaseJsonResource
     */
    public function setRoles(int $id, Collection $roles): BaseJsonResource
    {
        $user = User::query()->findOrFail($id);
        $user->setRoles($roles);

        return $this->resource($user);
    }
}
