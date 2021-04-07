<?php

namespace Dskripchenko\LaravelApiUser\Models;

use Dskripchenko\Schemify\Traits\DynamicConnectionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class UserPermission
 * @package Dskripchenko\LaravelApiUser\Models
 */
class UserPermission extends Model
{
    use DynamicConnectionTrait;

    public $timestamps = null;

    /**
     * @return BelongsToMany
     */
    public function userRoles(): BelongsToMany
    {
        return $this->belongsToMany(UserRole::class, 'user_role2user_permissions');
    }

    /**
     * @param string $key
     * @param string $name
     * @param string $group
     * @return UserPermission
     */
    public static function create(string $key, string $name, string $group): UserPermission
    {
        $instance = new static();
        $instance->key = $key;
        $instance->name = $name;
        $instance->group = $group;
        $instance->save();
        return $instance;
    }
}
