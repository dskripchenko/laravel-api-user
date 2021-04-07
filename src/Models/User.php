<?php

namespace Dskripchenko\LaravelApiUser\Models;

use Dskripchenko\LaravelApiUser\Notifications\ResetPassword;
use Dskripchenko\LaravelApiUser\Notifications\UserCreated;
use Dskripchenko\Schemify\Traits\DynamicConnectionTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Dskripchenko\LaravelApiUser\Interfaces\User as UserInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;

/**
 * Class User
 * @package Dskripchenko\LaravelApiUser\Models
 */
class User extends Model implements UserInterface, AuthorizableContract, CanResetPasswordContract, AuthenticatableInterface
{
    use SoftDeletes, Authorizable, CanResetPassword, MustVerifyEmail, Notifiable, Authenticatable, DynamicConnectionTrait;

    protected $fillable = [
        'name', 'email'
    ];

    /**
     * @return array|mixed
     */
    public function getOptions()
    {
        $options = json_decode($this->options, true);
        if (!$this->options || !$options || !is_array($options)) {
            return [];
        }
        return $options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options = [])
    {
        $this->options = json_encode($options);
    }

    /**
     * @param array $options
     */
    public function addOptions($options = [])
    {
        $options = array_merge_deep($this->getOptions(), $options);
        $this->setOptions($options);
    }

    /**
     * @param $email
     * @param $name
     * @return \Dskripchenko\LaravelApiUser\Interfaces\User
     */
    public function register($email, $name): UserInterface
    {
        $this->email = $email;
        $this->name = $name;
        $this->save();

        $token = Password::broker()->createToken($this);
        $this->sendUserCreatedNotification($token);

        return $this;
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * @param string $token
     */
    public function sendUserCreatedNotification($token)
    {
        $this->notify(new UserCreated($token));
    }

    /**
     * @var array|null
     */
    protected $permissions = null;

    /**
     * @param $ability
     * @return bool
     */
    public function hasAbility($ability): bool
    {
        $abilities = $this->getAvailableAbilities();
        if(isset($abilities[$ability])) {
            return true;
        }

        return false;
    }

    /**
     * @param $ability
     * @param array $arguments
     * @return bool
     */
    public function allowAbility($ability, $arguments = []): bool
    {
        if($this->hasAbility('root')) {
            return true;
        }

        $method = "can" . Str::title(Str::lower($ability));
        if (method_exists($this, $method)) {
            return $this->$method($arguments);
        }

        if(!$this->hasAbility($ability)) {
            return false;
        }

        return true;
    }

    /**
     * @return BelongsToMany
     */
    public function userRoles(): BelongsToMany
    {
        return $this->belongsToMany(UserRole::class, 'user2user_roles')->with('userPermissions');
    }

    /**
     * @return array
     */
    public function getAvailableAbilities(): array
    {
        if(!is_array($this->permissions)) {
            $this->permissions = [];
            foreach ($this->userRoles as $role) {
                $this->permissions[] = $role->key;
                foreach ($role->userPermissions as $permission) {
                    $this->permissions[] = $permission->key;
                }
            }
            $permissions = array_unique($this->permissions);
            $this->permissions = array_combine($permissions, $permissions);
        }
        return $this->permissions;
    }

    /**
     * @param Collection $roles
     */
    public function addRoles(Collection $roles): void
    {
        /**
         * @var Collection $existRoles
         */
        $existRoles = $this->userRoles;

        $this->userRoles()->saveMany($roles->diff($existRoles));
        $this->refresh();
    }

    /**
     * @param Collection $roles
     */
    public function removeRoles(Collection $roles): void
    {
        $ids = $roles->map(function ($row, $key) {
            return $row->id;
        });

        $this->userRoles()->detach($ids);
        $this->refresh();
    }


    /**
     * @param Collection $roles
     */
    public function setRoles(Collection $roles): void
    {
        $this->clearRoles();
        $this->addRoles($roles);
    }

    public function clearRoles(): void
    {
        $this->userRoles()->sync([]);
        $this->refresh();
    }
}
