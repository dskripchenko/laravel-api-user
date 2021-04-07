<?php

namespace Dskripchenko\LaravelApiUser\Providers;

use Dskripchenko\LaravelApi\Providers\BaseServiceProvider;
use Dskripchenko\LaravelApiUser\Commands\PackagePostInstall;
use Dskripchenko\LaravelApiUser\Interfaces\User as UserInterface;
use Dskripchenko\LaravelApiUser\Interfaces\UserService as UserServiceInterface;
use Dskripchenko\LaravelApiUser\Services\UserService;
use Dskripchenko\LaravelApiUser\Models\User;
use Dskripchenko\LaravelApiUser\Validators\CanValidator;
use Illuminate\Support\Facades\Gate;

/**
 * Class UserServiceProvider
 * @package Dskripchenko\LaravelApiUser\Providers
 */
class UserServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__, 2) . '/config/api.php', 'api');
        $this->mergeConfigFrom(dirname(__DIR__, 2) . '/config/auth.php', 'auth');

        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserInterface::class, User::class);


        $this->commands([
            PackagePostInstall::class
        ]);

        Gate::before(function (UserInterface $user, $ability, $arguments) {
            if(Gate::has($ability)) {
                return Gate::allows($ability, $arguments);
            }
            return $user->allowAbility($ability, $arguments);
        });

        $this->app->register(CanValidator::class);

        parent::register();
    }
}
