@extends('layouts.master')

@section('content')
    <div class="bg-light p-5 mx-auto" style="max-width: 1200px">
        <div class="mb-4">
            <h2 class="text-center">@lang('lang.profile')</h2>
        </div>
        <div class="d-flex justify-content-center mb-4">
            <img src="{{ $user->profile_picture ?? asset('assets/img/profile.png') }}" alt=""
                style="width: 150px; border-radius: 100%; border: 2px solid; padding: 10px">
        </div>
        <div class="mb-4 d-flex justify-content-between">
            <div>
                <h3 class="">{{ $user->name }}</h3>
                <h6>{{ $user->profession->name }}</h6>
                <a href="">{{ $user->friends()->where('status', 'accepted')->count() }} @lang('lang.friends')</a>
            </div>
            <div>
                @foreach ($user->userFields as $uf)
                    <p class="mb-1 text-end">{{ $uf->fieldOfWork->name }}</p>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <a href="{{ route('logout') }}" class="btn btn-danger">@lang('lang.logout')</a>
        </div>
    </div>
@endsection
