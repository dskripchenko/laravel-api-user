<?php

namespace Dskripchenko\LaravelApiUser\Requests;

use Dskripchenko\LaravelApi\Exceptions\ApiException;
use Dskripchenko\LaravelApiUser\Models\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RequestWithRoles
 * @package Dskripchenko\LaravelApiUser\Requests
 */
class RequestWithRoles extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:users,id',
            'roleIds' => 'required|string|regex:/^[\d,]+$/'
        ];
    }

    /**
     * @return Collection
     * @throws ApiException
     */
    public function getRoles(): Collection
    {
        $roleIds = explode(',', $this->roleIds);
        $roleIds = array_unique($roleIds);
        $roleIds = array_filter($roleIds,function ($id) {
            return is_numeric($id) && $id > 0;
        });

        if(empty($roleIds)) {
            throw new ApiException('invalid_roleIds', 'Некорректный список идентификаторов ролей');
        }

        return UserRole::query()->whereIn('id', $roleIds)->get();
    }

}
