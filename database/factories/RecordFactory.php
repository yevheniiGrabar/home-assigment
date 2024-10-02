<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::query()->inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'image' => $this->faker->image,
            'category_id' => Category::query()->inRandomOrder()->first()->id,
        ];
    }
}
