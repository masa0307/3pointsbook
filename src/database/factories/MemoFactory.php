<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MemoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'before_reading_content' => $this->faker->word(),
            'reading_content'        => $this->faker->word(),
            'after_reading_content'  => $this->faker->word(),
            'actionlist1_content'    => $this->faker->word(),
            'actionlist2_content'    => $this->faker->word(),
            'actionlist3_content'    => $this->faker->word(),
            'feedback1_content'      => $this->faker->word(),
            'feedback2_content'      => $this->faker->word(),
            'feedback3_content'      => $this->faker->word(),
        ];
    }
}
