<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $avatars = Avatar::get();

        return view('pages.avatar', compact('user', 'notifications', 'avatars'));
    }

    public function purchase($avatar_id)
    {
        $user = User::find(Auth::user()->id);
        $avatar = Avatar::find($avatar_id);

        if (!$avatar) {
            return redirect()->back()->with('error', 'Avatar not found.');
        }

        $transactionExists = Transaction::where('user_id', $user->id)
            ->where('avatar_id', $avatar_id)
            ->exists();

        if ($transactionExists) {
            $user->profile_picture = $avatar->image;
            $user->save();

            return redirect()->back()->with('success', 'Profile picture updated successfully!');
        }

        if ($user->coins < $avatar->price) {
            return redirect()->back()->with('error', 'Not enough coins to purchase this avatar.');
        }
        $user->coins -= $avatar->price;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'avatar_id' => $avatar_id,
        ]);

        $user->profile_picture = $avatar->image;
        $user->save();

        return redirect()->back()->with('success', 'Avatar purchased and profile picture updated!');
    }

    public function remove_profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $isRemoving = $request->input('remove', true);

        $cost = $isRemoving ? 50 : 5;
        if ($user->coins < $cost) {
            return redirect()->back()->withErrors(['message' => __('lang.not_enough_coins')]);
        }
        $user->coins -= $cost;

        if ($isRemoving) {
            $bearAvatar = Avatar::whereBetween('id', [1, 3])->inRandomOrder()->first();
            $user->profile_picture = $bearAvatar->image;
            $user->is_visible = false;
        } else {
            $user->visible = true;
            $user->profile_picture = $user->original_picture;
        }

        $user->save();

        return redirect()->back()->with('success', $isRemoving ? __('lang.profile_removed') : __('lang.profile_restored'));
    }
}
