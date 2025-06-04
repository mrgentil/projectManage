<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;



class MessagePolicy
{
    public function view(User $user, Message $message): bool
    {
        return true; // Allow viewing messages if the user is authenticated
        //return $message->sender_id === $user->id || $message->receiver_id === $user->id;
    }
}
