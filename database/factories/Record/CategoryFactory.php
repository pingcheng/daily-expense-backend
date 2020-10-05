<?php

namespace Database\Factories\Record;

use App\Models\Record\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
			'user_id' => 1,
			'name' => $this->faker->word,
			'type' => Category::TYPE_EXPENSE,
        ];
    }
}
