<?php


namespace Dskripchenko\LaravelApiUser\Interfaces;


interface User
{
    public function register($email, $name) : User;
}
