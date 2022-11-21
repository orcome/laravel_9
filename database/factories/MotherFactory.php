<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Mother;
use Illuminate\Database\Eloquent\Factories\Factory;

class MotherFactory extends Factory
{
    protected $model = Mother::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->word,
            'description' => $this->faker->sentence,
            'creator_id'  => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
