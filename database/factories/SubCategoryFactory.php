<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Record\SubCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(SubCategory::class, static function (Faker $faker) {
    return [
        'user_id' => 1,
		'category_id' => 1,
		'name' => $faker->word,
    ];
});
