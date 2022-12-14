<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Sister;
use Illuminate\Database\Eloquent\Factories\Factory;

class SisterFactory extends Factory
{
    protected $model = Sister::class;

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
