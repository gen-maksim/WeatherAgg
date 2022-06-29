<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RequestStatFactory extends Factory
{
    public function definition(): array
    {

        return [
            'endpoint' => implode('-', $this->faker->words(2)),
            'date' => $this->faker->date()
        ];
    }
}
