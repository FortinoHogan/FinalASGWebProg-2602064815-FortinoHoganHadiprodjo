@extends('layouts.master')

@section('content')
    <style>
        #card-content {
            justify-content: space-between;
        }

        @media (max-width: 640px) {
            #card-container {
                flex-direction: column;
            }

            #card-content {
                flex-direction: column;
                justify-content: center;
            }

            #profile-picture {
                width: 100px !important;
            }
        }
    </style>
    <div class="bg-light px-3 py-5 mx-auto" style="max-width: 640px">
        <div class="mb-4">
            <h2 class="text-center">@lang('lang.friends')</h2>
        </div>
        <div class="d-flex flex-column gap-3">
            @forelse ($friends as $friend)
                <div class="d-flex justify-content-between align-items-center gap-3 p-3" id="card-container"
                    style="border: 1px solid">
                    <img src="{{ $friend->profile_picture ?? asset('assets/img/profile.png') }}" alt=""
                        style="width: 150px; border-radius: 100%; border: 2px solid; padding: 10px" id="profile-picture" />
                    <div class="d-flex align-items-center w-100 gap-3" id="card-content">
                        <h5 class="text-center">
                            @if (Auth::user()->id < $friend->user_id || Auth::user()->id == $friend->friend_id)
                                {{ $friend->user->name }}
                            @else
                                {{ $friend->friend->name }}
                            @endif
                        </h5>
                        @if ($friend->status == 'accepted')
                            <form action="{{ route('friends.remove', $friend->sender_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; cursor: pointer;">
                                    <i class="fa-solid fa-thumbs-up" style="font-size: 1.5rem;"></i>
                                </button>
                            </form>
                        @elseif ($friend->status == 'pending' && $friend->friend->sender_id == Auth::user()->id)
                            <form action="{{ route('friends.remove', $friend->sender_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; cursor: pointer;">
                                    <i class="fa-regular fa-clock" style="font-size: 1.5rem;"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('friends.add', $friend->sender_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; cursor: pointer;">
                                    <i class="fa-regular fa-thumbs-up" style="font-size: 1.5rem;"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <h5 class="text-center">@lang('lang.no_friend')</h5>
            @endforelse
        </div>
    </div>
    <a href="{{ route('chat') }}" class="bg-white position-fixed p-3 shadow-lg" style="border-radius: 100%; bottom: 20px; right: 20px; cursor: pointer;">
        <i class="fa-regular fa-comments" style="font-size: 1.5rem;"></i>
    </a>
@endsection
