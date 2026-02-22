<?php

namespace EPSJV\Acl\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__."/../database/seeders/AclPapelPermissaoTableSeeder.php" => database_path("seeders/AclPapelPermissaoTableSeeder.php"),
            __DIR__."/../database/seeders/AclPapelTableSeeder.php" => database_path("seeders/AclPapelTableSeeder.php"),
            __DIR__."/../database/seeders/AclPapelUserTableSeeder.php" => database_path("seeders/AclPapelUserTableSeeder.php"),
            __DIR__."/../database/seeders/AclPermissaoTableSeeder.php" => database_path("seeders/AclPermissaoTableSeeder.php"),
        ], 'acl-seeders');
    }

}   