<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Master;
use Illuminate\Database\Eloquent\Factories\Factory;

class MasterFactory extends Factory
{
    protected $model = Master::class;

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
