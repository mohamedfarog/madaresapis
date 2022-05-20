<?php

namespace Database\Factories\Website;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class QuestionedAnswersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'  =>  ['en' =>$this->faker->sentence($nbWords = 5, $variableNbWords = true), 'ar'=>$this->faker->sentence($nbWords = 5, $variableNbWords = true)],
            'body'  =>[ 'en' =>$this->faker->paragraph($nbSentences = 3, $variableNbSentences = true) , 'ar'=>$this->faker->paragraph($nbSentences = 3, $variableNbSentences = true)],
        ];
    }
}
