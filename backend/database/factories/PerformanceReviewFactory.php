<?php

namespace Database\Factories;

use App\Models\PerformanceReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerformanceReviewFactory extends Factory
{
    protected $model = PerformanceReview::class;

    public function definition(): array
    {
        $reviewed = User::inRandomOrder()->first()?->id ?? User::factory();
        $reviewer = User::inRandomOrder()->first()?->id ?? User::factory();

        return [
            'user_id' => $reviewed,
            'reviewer_id' => $reviewer,
            'review_type' => $this->faker->randomElement(['Année', 'Semi Année', 'Probation']),
            'comments' => $this->faker->paragraph,
            'rating' => rand(1, 5),
        ];
    }
}
