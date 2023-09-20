<?php

namespace Masoudi\Laravel\Visitors\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Masoudi\Laravel\Visitors\Middlewares\VisitMiddleware;
use Masoudi\Laravel\Visitors\Models\Visitor;

class VisitorServiceProvider extends ServiceProvider
{
    public function boot()
    {

        // Add a macro for visit requests
        if (method_exists(Request::class, "macro")) {
            Request::macro("visit", function () {
                if ($this instanceof Request) {
                    Visitor::visit($this);
                }
            });
        }

        // Register visitor middleware
        if (isset($this->app['router'])) {
            $router = $this->app['router'];
            $router->aliasMiddleware("visitor", VisitMiddleware::class);
        }

        $this->publishes([
            __DIR__ . "/../../database/2022_09_06_192335_create_visitors_table.php"
            => database_path("migrations/2022_09_06_192335_create_visitors_table.php")
        ], 'masoudi-laravel-visitors');
    }
}
