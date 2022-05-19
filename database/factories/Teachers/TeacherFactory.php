<?php

namespace Database\Factories\Teachers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gender_id' => rand(1,3),
            'job_level_id' => rand(1,3),
            'first_name' => $this->faker->word,
            'last_name' => $this->faker->word,
            'mobile'  =>$this->faker->numberBetween($min = 1000000, $max = 9000000),
            'date_of_birth'  => $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null) ,
            'avatar' => $this->faker->randomElement(['avatar-1.jpg','avatar-2.jpg' , 'avatar-3.jpg' , 'avatar-4.jpg' , 'avatar-5.jpg','avatar-6.jpg','avatar-7.jpg','avatar-8.jpg']),
            'academic_major' =>$this->faker->randomElement(['Mathematics' , 'Science' , 'Health' , 'Handwriting','Music' , 'Dramatics']),
            'bio' => $this->faker->sentence($nbWords = 8, $variableNbWords = true),

        ];
    }
}
