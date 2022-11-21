<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Brother;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrotherFactory extends Factory
{
    protected $model = Brother::class;

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
