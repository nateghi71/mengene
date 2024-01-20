<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecialFile>
 */
class SpecialFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type_sale = $this->faker->randomElement(['rahn' , 'buy']);
        return [
            'name' => $this->faker->name,
            'number' => '09356317466',
            'city_id' => rand(1,440),
            'type_sale' => $type_sale,
            'type_work' => $this->faker->randomElement(['home' , 'office']),
            'type_build' => $this->faker->randomElement(['house' , 'apartment']),
            'type_file' => $this->faker->randomElement(['public', 'buy', 'subscription']),
            'scale' => $this->faker->numberBetween(50,300),
            'number_of_rooms' => $this->faker->numberBetween(0,10),
            'description' => $this->faker->randomElement(['طبرسی' , 'پیروزی', 'استقلال', 'مهراباد']),
            'rahn_amount' => $type_sale === "rahn" ? rand(1,9) * 10 : 0,
            'rent_amount' => $type_sale === "rahn" ? rand(1,9) : 0,
            'selling_price' => $type_sale === "buy" ? rand(1,9) * 100 : 0,
            'elevator' => $this->faker->boolean,
            'parking' => $this->faker->boolean,
            'store' => $this->faker->boolean,
            'floor' => $this->faker->numberBetween(0,10),
            'floor_number' => $this->faker->numberBetween(0,10),
            'user_id' => rand(1,2),
            'is_star' => 0,
            'expire_date' => $this->faker->dateTimeBetween(Carbon::parse('last day of november 2023'), Carbon::now()->addDays(90))
        ];
    }
}
