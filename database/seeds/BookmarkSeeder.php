<?php

use Aleksei4er\TaskBookmarks\Models\Bookmark;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Bookmark::class, 7)->create();
    }
}
