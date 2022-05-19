<?php

namespace Database\Factories\Teachers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class TeacherResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'curriculum_vitae' => $this->faker->randomElement(['cv-1.pdf','cv-2.pdf' , 'cv-3.pdf' , 'cv-4.pdf' , 'cv-5.pdf','cv-6.pdf','cv-7.pdf','cv-8.pdf']),
            'cover_litter' => $this->faker->sentence($nbWords = 8, $variableNbWords = true),
        ];
    }
}
