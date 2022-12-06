<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuantityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->numberBetween(10,50),
        ];
    }
}
