<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Record\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, static function (Faker $faker) {
    return [
    	'user_id' => 1,
		'name' => $faker->word,
		'type' => Category::TYPE_EXPENSE,
    ];
});
