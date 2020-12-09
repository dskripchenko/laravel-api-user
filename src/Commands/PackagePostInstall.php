<?php

namespace Dskripchenko\LaravelApiUser\Commands;

use Dskripchenko\LaravelCMI\Components\InstallMigrationsCommand;

class PackagePostInstall extends InstallMigrationsCommand
{
    protected $componentName = 'user';

    protected $signature = 'cmi:user:install';

    protected $description = 'Installing user component migrations';

    protected function getMigrationsDir(): string
    {
        return dirname(__DIR__, 2) . '/database/migrations';
    }

    protected function getMigrations(): array
    {
        return [
            '001_create_users_table.php',
            '002_create_password_resets_table.php',
            '003_add_options_to_users_table.php',
        ];
    }
}
