<?php

namespace App\Http\Controllers\API;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewPrivateMessage;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|not_in:' . auth()->id(),
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        // Notification
        $receiver = User::find($request->receiver_id);
        $receiver->notify(new NewPrivateMessage($message));

        return response()->json([
            'message' => 'Message envoyé avec succès.',
            'data' => $message
        ], 201);
    }

    public function inbox()
    {
        return Message::with('sender')
            ->where('receiver_id', auth()->id())
            ->latest()
            ->get();
    }

    public function sent()
    {
        return Message::with('receiver')
            ->where('sender_id', auth()->id())
            ->latest()
            ->get();
    }

    public function show(Message $message)
    {
        $this->authorize('view', $message);

        if ($message->receiver_id === auth()->id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return $message->load('sender', 'receiver');
    }
}
