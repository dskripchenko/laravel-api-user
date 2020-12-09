<?php

namespace Dskripchenko\LaravelApiUser\Models;


use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

class User extends Model implements \Dskripchenko\LaravelApiUser\Interfaces\User,
    AuthorizableContract,
    CanResetPasswordContract
{
    use SoftDeletes,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail,
        Notifiable;

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
     * @param $login
     * @param array $options
     * @return $this|\Dskripchenko\LaravelApiUser\Interfaces\User
     */
    public function register($login, $options = []): \Dskripchenko\LaravelApiUser\Interfaces\User
    {
        $this->login = $login;
        $this->setOptions($options);
        $this->save();
        return $this;
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
