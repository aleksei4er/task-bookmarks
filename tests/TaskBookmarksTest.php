<?php

namespace Aleksei4er\TaskBookmarks\Tests;

use Aleksei4er\TaskBookmarks\Facades\TaskBookmarks;
use Aleksei4er\TaskBookmarks\ServiceProvider;
use Orchestra\Testbench\TestCase;

class TaskBookmarksTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'task-bookmarks' => TaskBookmarks::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
