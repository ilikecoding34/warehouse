<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'minimumlevel' => 15,
            'price' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
