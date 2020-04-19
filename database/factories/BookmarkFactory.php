<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Aleksei4er\TaskBookmarks\Models\Bookmark;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(Bookmark::class, function (Faker $faker) {
    $url = $faker->unique()->url();
    return [
        'favicon' => $faker->imageUrl(16, 16),
        'url' => $url,
        'url_hash' => Hash::make($url),
        'title' => $faker->sentence(),
        'description' => $faker->text(255),
        'keywords' => $faker->words(5, true),
    ];
});
