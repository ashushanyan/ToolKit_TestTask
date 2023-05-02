<?php

namespace Database\Factories;

use App\Models\Statement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatementFactory extends Factory
{
    protected $model = Statement::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'number' => $this->faker->randomNumber(),
            'date' => $this->faker->date(),
            'user_id' => User::factory(),
        ];
    }
}
