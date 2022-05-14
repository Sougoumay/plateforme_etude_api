<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(3,true),
            'content' => $this->faker->paragraph(6,true),
            'code' => $this->faker->regexify('I{1}K{1}-[A-Z]{3}[0-9]{3}'),
            'credit' =>$this->faker->numberBetween(1,5),
            'teacher_id' => $this->faker->randomElement([2,3,7,5,10])
        ];
    }
}
