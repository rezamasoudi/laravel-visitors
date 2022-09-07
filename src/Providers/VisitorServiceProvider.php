<?php

namespace Masoudi\Laravel\Visitors\Providers;

use Illuminate\Support\ServiceProvider;

class VisitorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../../database/2022_09_06_192335_create_visitors_table.php"
            => database_path("migrations/2022_09_06_192335_create_visitors_table.php")
        ], 'masoudi-laravel-visitors');
    }
}
