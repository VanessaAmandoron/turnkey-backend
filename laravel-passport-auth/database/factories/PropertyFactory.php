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
            'title' => $this->faker->word,
            'price' => $this->faker->numberBetween($min = 15000, $max = 3000000),
            'type' => $this->faker->randomElement([1, 2]),
            'area' => $this->faker->randomDigit,
            'bedroom' => $this->faker->randomDigit,
            'bathroom' => $this->faker->randomDigit,
            'description' => $this->faker->word,
            'address_1' => $this->faker->address,
            'address_2' => $this->faker->address,
            'zip_code' => $this->faker->randomDigit,
            'city' => $this->faker->name,
            'img' => $this->faker->imageUrl( 400, 300)
        ];
    }
}
