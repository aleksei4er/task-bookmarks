<?php

namespace Aleksei4er\TaskBookmarks;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/task-bookmarks.php';

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
    }
}
