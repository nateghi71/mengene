<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'en_name' => $this->faker->name,
            'user_id' => rand(1,2),
            'image' => $this->faker->image,
            'city' => $this->faker->city,
            'area' => $this->faker->postcode,
            'address' => $this->faker->address
        ];
    }
}
