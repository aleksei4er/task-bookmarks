<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bookmarks')) {
            Schema::create('bookmarks', function (Blueprint $table) {
                $table->id();
                $table->string('favicon')->nullable();
                $table->string('url', 2083);
                $table->string('url_hash')->unique();
                $table->string('title')->nullable();
                $table->string('description')->nullable();
                $table->string('keywords')->nullable();
                $table->string('password');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}
