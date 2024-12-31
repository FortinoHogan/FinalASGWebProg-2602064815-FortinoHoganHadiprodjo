@extends('layouts.master')

@section('content')
    <style>
        @media (max-width: 640px) {
            .content {
                flex-direction: column !important;
            }

            .content-left {
                text-align: center !important;
            }

            .fields {
                text-align: center !important;
            }
        }
    </style>
    <div class="bg-light p-5 mx-auto flex-grow" style="max-width: 1200px">
        <div class="mb-4">
            <h2 class="text-center">@lang('lang.profile')</h2>
        </div>
        <div class="d-flex justify-content-center mb-4">
            <img src="{{ $user->profile_picture ? 'data:image/jpeg;base64,' . base64_encode($user->profile_picture) : asset('assets/img/profile.png') }}"
                alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 100%; border: 2px solid; padding: 10px; object-fit: scale-down; object-position: top">
        </div>
        <div class="mb-4 d-flex justify-content-between content">
            <div class="d-flex flex-column gap-1 content-left">
                <h3 class="">{{ $user->name }}</h3>
                <h6>{{ $user->profession->name }}</h6>
                <a href="{{ route('friends') }}">{{ $friendsCount }} @lang('lang.friends')</a>
                <a href="{{ route('topup') }}">Coin: {{ $user->coins }}</a>
            </div>
            <div>
                @foreach ($user->userFields as $uf)
                    <p class="mb-1 text-end fields">{{ $uf->fieldOfWork->name }}</p>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <a href="{{ route('remove-profile') }}" class="btn btn-primary">@lang('lang.remove_profile')</a>
            <a href="{{ route('avatar') }}" class="btn btn-primary">@lang('lang.change_profile_picture')</a>
            <a href="{{ route('logout') }}" class="btn btn-danger">@lang('lang.logout')</a>
        </div>
    </div>
    <a href="{{ route('chat') }}" class="bg-white position-fixed p-3 shadow-lg"
        style="border-radius: 100%; bottom: 20px; right: 20px; cursor: pointer;">
        <i class="fa-regular fa-comments" style="font-size: 1.5rem;"></i>
    </a>
@endsection
