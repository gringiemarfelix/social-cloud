<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'description' => $this->faker->sentence(),
            'image' => 'https://via.placeholder.com/640x480'
        ];
    }
}
