<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function InterestingState(){
        return $this->state(function () {
            return [
                'state' => '気になる',
            ];
        });
    }

    public function ReadingState(){
        return $this->state(function () {
            return [
                'state' => '読書中',
            ];
        });
    }

    public function definition()
    {
        return [
            'title'      => $this->faker->word(),
            'title_kana' => $this->faker->word(),
            'author'     => $this->faker->word(),
            'image_path' => $this->faker->imageUrl(),
        ];
    }
}
