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
        $transactions = Transaction::where('user_id', $user->id)->get();

        return view('pages.avatar', compact('user', 'notifications', 'avatars', 'transactions'));
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

            return redirect()->back()->with('success', __('lang.profile_updated'));
        }

        if ($user->coins < $avatar->price) {
            return redirect()->back()->with('error', __('lang.not_enough_coins'));
        }
        $user->coins -= $avatar->price;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'avatar_id' => $avatar_id,
        ]);

        $user->profile_picture = $avatar->image;
        $user->save();

        return redirect()->back()->with('success', __('lang.avatar_purchased'));
    }

    public function remove_profile()
    {
        $user = User::find(Auth::user()->id);

        $cost = 50;
        if ($user->coins < $cost) {
            return redirect()->back()->with('error', __('lang.not_enough_coin_to_remove'));
        }
        $user->coins -= $cost;

        $bearAvatar = Avatar::whereBetween('id', [1, 3])->inRandomOrder()->first();
        $user->profile_picture = $bearAvatar->image;
        $user->is_visible = false;

        $user->save();

        return redirect()->back()->with('success',  __('lang.profile_removed'));
    }

    public function restore_profile()
    {
        $user = User::find(Auth::user()->id);
        
        $cost = 5;
        if ($user->coins < $cost) {
            return redirect()->back()->with('error', __('lang.not_enough_coin_to_restore'));
        }

        $user->coins -= $cost;
        $user->is_visible = true;
        $user->profile_picture = null;
        $user->save();
        return redirect()->back()->with('success', __('lang.profile_restored'));
    }
}
