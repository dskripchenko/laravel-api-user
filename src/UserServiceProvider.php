<?php

namespace Dskripchenko\LaravelApiUser;

use Dskripchenko\LaravelApiUser\Commands\PackagePostInstall;
use Dskripchenko\LaravelApiUser\Commands\PackagePreUninstall;
use Dskripchenko\LaravelApiUser\Interfaces\User;
use Dskripchenko\LaravelApiUser\Interfaces\UserService;
use Illuminate\Contracts\Foundation\CachesConfiguration;

class UserServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/api.php', 'api');

        $this->app->bind(UserService::class, \Dskripchenko\LaravelApiUser\Services\UserService::class);
        $this->app->bind(User::class, \Dskripchenko\LaravelApiUser\Models\User::class);

        $this->commands([
            PackagePostInstall::class,
            PackagePreUninstall::class
        ]);

        parent::register();
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param string $path
     * @param string $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        if (!($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $this->app['config']->set(
                $key,
                array_merge_deep(
                    require $path,
                    $this->app['config']->get($key, [])
                )
            );
        }
    }
}
