<?php

namespace Dskripchenko\LaravelApiUser;

use Dskripchenko\LaravelApiUser\Commands\PackagePostInstall;
use Dskripchenko\LaravelApiUser\Commands\PackagePreUninstall;
use Dskripchenko\LaravelApiUser\Interfaces\User;
use Dskripchenko\LaravelApiUser\Interfaces\UserService;

class UserServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserService::class, \Dskripchenko\LaravelApiUser\Services\UserService::class);
        $this->app->bind(User::class, \Dskripchenko\LaravelApiUser\Models\User::class);

        $this->commands([
            PackagePostInstall::class,
            PackagePreUninstall::class
        ]);

        parent::register();
    }
}
