<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type;
use App\Models\User;
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
        $list = [
            'SMC','Eaton','Siemens','Carl Valentin','Weidmüller','BOS','Lipowsky','Omron','Keyence','Moxa','Festo', 'Pepperl+Fuchs', 'HBM'
        ];

        return [
            'uniquename' => $this->faker->unique()->word(),
            'serialnumber' => $this->faker->unique()->numberBetween(10,20000),
            'minimumlevel' => $this->faker->numberBetween(10,50),
            'price' => $this->faker->numberBetween(1,200),
            'quantity' => $this->faker->numberBetween(1,50),
            'company' => $this->faker->randomElement($list),
            'location' => $this->faker->word(),
            'type' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'created_by_user' => $this->faker->name(),
            'updated_by_user' => $this->faker->name(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
