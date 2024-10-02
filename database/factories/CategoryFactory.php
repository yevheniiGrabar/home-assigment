<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'Full-time', 'Part-time',
                'Contract', 'Independent contractor',
                'Temporary', 'On-call',
                'Volunteer'
            ])
        ];
    }
}
