<?php

namespace Dskripchenko\LaravelApiUser\Models;

use Dskripchenko\Schemify\Traits\DynamicConnectionTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRole extends Model
{
    use DynamicConnectionTrait;

    public $timestamps = null;

    /**
     * @return BelongsToMany
     */
    public function userPermissions(): BelongsToMany
    {
        return $this->belongsToMany(UserPermission::class, 'user_role2user_permissions');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user2user_roles');
    }

    /**
     * @param string $key
     * @param string $name
     * @return UserRole
     */
    public static function create(string $key, string $name): UserRole
    {
        $instance = new static();
        $instance->key = $key;
        $instance->name = $name;
        $instance->save();
        return $instance;
    }

    /**
     * @param Collection $permissions
     */
    public function addPermissions(Collection $permissions): void
    {
        /**
         * @var Collection $existPermissions
         */
        $existPermissions = $this->userPermissions;

        $this->userPermissions()->saveMany($permissions->diff($existPermissions));
        $this->refresh();
    }

    public function clearPermissions(): void
    {
        $this->userPermissions()->sync([]);
        $this->refresh();
    }

    /**
     * @param Collection $permissions
     */
    public function setPermissions(Collection $permissions): void
    {
        $this->clearPermissions();
        $this->addPermissions($permissions);
    }

    /**
     * @param Collection $permissions
     */
    public function removePermissions(Collection $permissions): void
    {
        $ids = $permissions->map(function ($row, $key) {
            return $row->id;
        });

        $this->userPermissions()->detach($ids);
        $this->refresh();
    }

    /**
     * @param Collection $users
     */
    public function addUsers(Collection $users): void
    {
        /**
         * @var Collection $existUsers
         */
        $existUsers = $this->users;

        $this->users()->saveMany($users->diff($existUsers));
        $this->refresh();
    }


    public function clearUsers(): void
    {
        $this->users()->sync([]);
        $this->refresh();
    }

    /**
     * @param Collection $users
     */
    public function removeUsers(Collection $users): void
    {
        $ids = $users->map(function ($row, $key) {
            return $row->id;
        });

        $this->users()->detach($ids);
        $this->refresh();
    }
}
