<?php

namespace Dskripchenko\LaravelApiUser\Interfaces;

/**
 * Interface User
 * @package Dskripchenko\LaravelApiUser\Interfaces
 */
interface User
{
    /**
     * @param $email
     * @param $name
     * @return User
     */
    public function register($email, $name) : User;

    /**
     * @param $ability
     * @return bool
     */
    public function hasAbility($ability): bool;

    /**
     * @param $ability
     * @param array $arguments
     * @return bool
     */
    public function allowAbility($ability, $arguments = []): bool;
}
