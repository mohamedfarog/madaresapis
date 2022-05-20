<?php

namespace Database\Factories\Academies;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


class AcademyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'website'  =>$this->faker->domainName(),
            'contact_number'  =>$this->faker->numberBetween($min = 1000000, $max = 9000000),
            'contact_email'  => $this->faker->companyEmail() ,
            'avatar' => $this->faker->randomElement(['avatar-1.jpg','avatar-2.jpg' , 'avatar-3.jpg' , 'avatar-4.jpg' , 'avatar-5.jpg','avatar-6.jpg','avatar-7.jpg','avatar-8.jpg']),
            'banner' => $this->faker->randomElement(['banner-1.jpg','banner-2.jpg' , 'banner-3.jpg' , 'banner-4.jpg' , 'banner-5.jpg','banner-6.jpg','banner-7.jpg','banner-8.jpg']),
            'bio' => $this->faker->sentence($nbWords = 8, $variableNbWords = true),

        ];
    }
}
