<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'author' => $this->faker->name,
            'cover_image' => 'https://via.placeholder.com/150', // Placeholder image
            'start_price' => $this->faker->randomFloat(2, 5, 50),
        ];
    }
}