<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friendA = Friend::where('user_id', $user->id)->where('status', 'accepted')->get();
        $friendB = Friend::where('friend_id', $user->id)->where('status', 'accepted')->get();

        $friends = $friendA->merge($friendB);

        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('pages.chat', compact('notifications', 'friends'));
    }

    public function get_messages($friendId)
    {
        $userId = Auth::user()->id;

        $messages = Message::where(function ($query) use ($userId, $friendId) {
            $query->where('sender_id', $userId)->where('receiver_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('sender_id', $friendId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }

    public function send_message(Request $request, $friendId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $friendId,
            'content' => $request->input('content'),
        ]);

        Notification::create([
            'user_id' => $friendId,
            'sender_id' => Auth::user()->id,
            'content' => $request->input('content'),
            'type' => 'message',
        ]);

        $messages = Message::where(function ($query) use ($friendId) {
            $query->where('sender_id', Auth::user()->id)->where('receiver_id', $friendId);
        })
            ->orWhere(function ($query) use ($friendId) {
                $query->where('sender_id', $friendId)->where('receiver_id', Auth::user()->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }
}
