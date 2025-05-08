<?php

namespace Database\Factories;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    protected $model = Leave::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month', 'now');
        $end = (clone $start)->modify('+'.rand(1, 5).' days');

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'start_date' => $start,
            'end_date' => $end,
            'reason' => $this->faker->sentence(6),
            'type' => $this->faker->randomElement(['Payé', 'Malade', 'Impayé', 'TéléTravail']),
            'status' => $this->faker->randomElement(['En cours', 'Approuvé', 'Réjeté']),
        ];
    }
}
