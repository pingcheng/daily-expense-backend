<?php

namespace Database\Factories\Record;

use App\Models\Record\Record;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Record::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
	{
        return [
			'sub_category_id' => 1,
			'description' => $this->faker->word,
			'amount' => rand(100, 100000),
			'user_id' => 1,
			'datetime' => Carbon::now()
				->startOfDay()
				->addDays(rand(-10, 10))
				->addHours(rand(0, 23))
				->addMinutes(rand(0, 59))
        ];
    }
}
