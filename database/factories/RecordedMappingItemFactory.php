<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecordedMappingItemFactory extends Factory
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
            'x_point' => 5,
            'y_point' => 5,
        ];
    }
}
