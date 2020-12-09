<?php

namespace Dskripchenko\LaravelApiUser\Commands;

use Dskripchenko\LaravelCMI\Components\UninstallMigrationsCommand;

class PackagePreUninstall extends UninstallMigrationsCommand
{
    protected $componentName = 'user';

    protected $signature = 'cmi:user:uninstall';

    protected $description = 'Removing migrations of the user component';
}
