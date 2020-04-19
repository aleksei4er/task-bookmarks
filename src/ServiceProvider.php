<?php

namespace Aleksei4er\TaskBookmarks;

use Aleksei4er\TaskBookmarks\Admin\Controllers\BookmarksController;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/task-bookmarks.php';
    const FACTORIES_PATH =  __DIR__ . '/../database/factories';
    const MIGRATIONS_PATH =  __DIR__ . '/../database/migrations';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('task-bookmarks.php'),
        ], 'config');

    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'task-bookmarks'
        );

        $this->app->bind('task-bookmarks', function () {
            return new TaskBookmarks();
        });

        $this->app->make(Factory::class)->load(self::FACTORIES_PATH);

        $this->loadMigrationsFrom(self::MIGRATIONS_PATH);

        $this->registerSeeds();

        Route::group([
            'prefix'        => config('admin.route.prefix'),
            'namespace'     => config('admin.route.namespace'),
            'middleware'    => config('admin.route.middleware'),
        ], function (Router $router) {
            $router->resource('bookmarks', '\\' . BookmarksController::class);
        });
    }

    /**
     * Include seed files
     *
     * @return void
     */
    protected function registerSeeds()
    {
        if ($this->app->runningInConsole()) {
            include(__DIR__ . '/../database/seeds/BookmarkSeeder.php');
        }
    }
}
