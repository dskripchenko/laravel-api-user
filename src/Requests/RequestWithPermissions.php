<?php

namespace Dskripchenko\LaravelApiUser\Requests;

use Dskripchenko\LaravelApi\Exceptions\ApiException;
use Dskripchenko\LaravelApiUser\Models\UserPermission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RequestWithPermissions
 * @package Dskripchenko\LaravelApiUser\Requests
 */
class RequestWithPermissions extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:layer.user_roles,id',
            'permissionIds' => 'required|string|regex:/^[\d,]+$/'
        ];
    }

    /**
     * @return Collection
     * @throws ApiException
     */
    public function getPermissions(): Collection
    {
        $permissionIds = explode(',', $this->permissionIds);
        $permissionIds = array_unique($permissionIds);
        $permissionIds = array_filter($permissionIds,function ($id) {
            return is_numeric($id) && $id > 0;
        });

        if(empty($permissionIds)) {
            throw new ApiException('invalid_permissionIds', 'Некорректный список идентификаторов функциональных разрешений');
        }

        return UserPermission::query()->whereIn('id', $permissionIds)->get();
    }
}
