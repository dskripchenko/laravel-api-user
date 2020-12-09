<?php

namespace Dskripchenko\LaravelApiUser\Interfaces;

interface UserService
{
    /**
     * @return User
     */
    public function register() : User;

    /**
     * @return bool
     */
    public function logout() : bool;

    /**
     * @return bool
     */
    public function login() : bool;

    /**
     * @return bool
     */
    public function resetPassword() : bool;

    /**
     * @return bool
     */
    public function passwordSet() : bool;

    /**
     * @return bool
     */
    public function passwordChange() : bool;

    /**
     * @return mixed
     */
    public function getLastError();
}
