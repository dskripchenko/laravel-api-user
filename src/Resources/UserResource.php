<?php

namespace Dskripchenko\LaravelApiUser\Resources;

use Dskripchenko\LaravelApi\Resources\BaseJsonResource;

/**
 * Class UserResource
 * @package Dskripchenko\LaravelApiUser\Resources
 */
class UserResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'options' => $this->getOptions(),
            'roles' => UserRoleResource::collection($this->userRoles)
        ];
    }
}
