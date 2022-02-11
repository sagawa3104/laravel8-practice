<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MappingItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'code' => $this->faker->name(),
            'content' => $this->faker->name(),
        ];
    }
}
