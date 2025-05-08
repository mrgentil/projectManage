<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        $sender = User::inRandomOrder()->first()?->id ?? User::factory();
        $receiver = User::inRandomOrder()->first()?->id ?? User::factory();

        return [
            'sender_id' => $sender,
            'receiver_id' => $receiver,
            'content' => $this->faker->sentence(10),
        ];
    }
}
