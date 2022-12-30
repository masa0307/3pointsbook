<?php

namespace Database\Factories;

use App\Models\MemoGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_owner'            => 0,
            'participation_status'=> '参加中'
        ];
    }
}
