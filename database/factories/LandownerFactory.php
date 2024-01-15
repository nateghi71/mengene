<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandownerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type_sale = $this->faker->randomElement(['rahn' , 'buy']);
        return [
            'name' => $this->faker->name,
            'number' => '09356317466',
            'city_id' => rand(1,440),
            'type_sale' => $type_sale,
            'type_work' => $this->faker->randomElement(['home' , 'office']),
            'type_build' => $this->faker->randomElement(['house' , 'apartment']),
            'access_level' => $this->faker->randomElement(['private' , 'public']),
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
            'business_id' => 1,
            'user_id' => rand(1,2),
            'is_star' => 0,
            'expire_date' => $this->faker->dateTimeBetween(Carbon::parse('last day of november 2023'), Carbon::now()->addDays(90))
        ];
    }
}
