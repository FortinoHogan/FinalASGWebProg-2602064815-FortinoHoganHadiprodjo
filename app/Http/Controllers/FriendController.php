<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $friendA = Friend::where('user_id', $user->id)->get();
        $friendB = Friend::where('friend_id', $user->id)->get();

        $friends = $friendA->merge($friendB);

        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('pages.friend-list', compact('friends', 'notifications'));
    }

    public function add_friend($userId)
    {
        $authUser = Auth::user();
        $userToAdd = User::findOrFail($userId);

        $userId = min($authUser->id, $userToAdd->id);
        $friendId = max($authUser->id, $userToAdd->id);

        $existingFriendship = Friend::where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->exists();

        if ($existingFriendship) {
            Friend::where('user_id', $userId)
                ->where('friend_id', $friendId)
                ->update(['status' => 'accepted']);
        } else {
            Friend::create([
                'user_id' => $userId,
                'friend_id' => $friendId,
                'status' => 'pending',
                'sender_id' => $authUser->id
            ]);

            Notification::create([
                'user_id' => $userToAdd->id,
                'sender_id' => $authUser->id,
                'content' => 'Friend request from ' . $authUser->name,
                'type' => 'friend_request',
            ]);
        }

        return back()->with('message', 'Friend request sent!');
    }

    public function remove_friend($user)
    {
        $authUser = Auth::user();
        $friend = Friend::where(function ($query) use ($authUser, $user) {
            $query->where('user_id', $authUser->id)
                ->where('friend_id', $user);
        })->orWhere(function ($query) use ($authUser, $user) {
            $query->where('user_id', $user)
                ->where('friend_id', $authUser->id);
        })->first();

        if ($friend) {
            $friend->delete();
            return back()->with('message', 'Friend removed!');
        }
    }
}
