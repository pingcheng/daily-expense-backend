<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Record\Record;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Record::class, static function (Faker $faker) {
    return [
        'sub_category_id' => 1,
		'description' => $faker->word,
		'amount' => random_int(100, 100000),
		'user_id' => 1,
		'datetime' => Carbon::now()
			->startOfDay()
			->addDays(random_int(-10, 10))
			->addHours(random_int(0, 23))
			->addMinutes(random_int(0, 59))
    ];
});
