<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type;
use App\Models\Company;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uniquename' => $this->faker->unique()->word(),
            'serialnumber' => $this->faker->unique()->numberBetween(10,20000),
            'minimumlevel' => $this->faker->numberBetween(10,50),
            'price' => $this->faker->numberBetween(1,200),
            'company_id' => Company::factory(),
            'location' => $this->faker->word(),
            'type_id' => Type::factory(),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
