<?php

namespace Dskripchenko\LaravelApiUser\Resources;

use Dskripchenko\LaravelApi\Resources\BaseJsonResource;

/**
 * Class UserPermissionResource
 * @package Dskripchenko\LaravelApiUser\Resources
 */
class UserPermissionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
            'group' => $this->group
        ];
    }
}
