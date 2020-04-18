<?php

namespace Aleksei4er\TaskBookmarks\Facades;

use Illuminate\Support\Facades\Facade;

class TaskBookmarks extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'task-bookmarks';
    }
}
