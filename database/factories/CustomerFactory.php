<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
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
            'city' => $this->faker->city,
            'type_sale' => $type_sale,
            'type_work' => $this->faker->randomElement(['home' , 'office']),
            'type_build' => $this->faker->randomElement(['house' , 'apartment']),
            'scale' => $this->faker->numberBetween(50,300),
            'number_of_rooms' => $this->faker->numberBetween(0,10),
            'description' => $this->faker->randomElement(['امام حسین' , 'عبادی', 'سعدی', 'کوهسنگی']),
            'rahn_amount' => $type_sale === "rahn" ? rand(1,9) * 10 : null,
            'rent_amount' => $type_sale === "rahn" ? rand(1,9) : null,
            'selling_price' => $type_sale === "buy" ? rand(1,9) * 100 : null,
            'elevator' => $this->faker->boolean,
            'parking' => $this->faker->boolean,
            'store' => $this->faker->boolean,
            'floor_number' => $this->faker->numberBetween(0,10),
            'business_id' => 1,
            'user_id' => rand(1,2),
            'is_star' => 0,
            'expire_date' => $this->faker->dateTimeBetween(new Carbon('last day of november 2023') , Carbon::now()->addDays(90))
        ];
    }
}
