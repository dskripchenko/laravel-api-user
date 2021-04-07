<?php

namespace Dskripchenko\LaravelApiUser\Commands;

use Dskripchenko\Schemify\Console\Migrations\InstallCommand;

/**
 * Class PackagePostInstall
 * @package Dskripchenko\LaravelApiUser\Commands
 */
class PackagePostInstall extends InstallCommand
{
    protected $componentName = 'user';

    protected $signature = 'user:install';

    protected $description = 'Установка миграций компонента user';

    protected function getMigrationsDir(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations';
    }
}
