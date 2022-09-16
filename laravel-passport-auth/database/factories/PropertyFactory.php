<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' =>  User::pluck('id')->random(),
            'p_title' => $this->faker->unique()->word,
            'price' => $this->faker->randomDigit,
            'p_type' => $this->faker->randomElement(['For Rent', 'For Sale']),
            'area' => $this->faker->randomDigit,
            'bedroom' => $this->faker->randomDigit,
            'bathroom' => $this->faker->randomDigit,
            'p_info' => $this->faker->words(30),
            'loc_a' => $this->faker->words,
            'loc_b' => $this->faker->words,
            'area' => $this->faker->randomDigit,
            'z_code' => $this->faker->randomDigit,
            'city' => $this->faker->name,
            'p_img' => "",
        ];
    }
}
