<?php

namespace Dskripchenko\LaravelApiUser\Resources;

use Dskripchenko\LaravelApi\Resources\BaseJsonResource;

/**
 * Class UserRoleResource
 * @package Dskripchenko\LaravelApiUser\Resources
 */
class UserRoleResource extends BaseJsonResource
{
    protected $withPermissions = false;

    /**
     * @return UserRoleResource
     */
    public function withPermissions(): UserRoleResource
    {
        $this->withPermissions = true;
        return $this;
    }

    /**
     * @return UserRoleResource
     */
    public function withoutPermissions(): UserRoleResource
    {
        $this->withPermissions = false;
        return $this;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
        ];

        if($this->withPermissions) {
            $result['permissions'] = UserPermissionResource::collection($this->userPermissions);
        }

        return $result;
    }
}
