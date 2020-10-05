<?php

namespace Database\Factories\Record;

use App\Models\Record\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
	{
        return [
			'user_id' => 1,
			'category_id' => 1,
			'name' => $this->faker->word,
        ];
    }
}
