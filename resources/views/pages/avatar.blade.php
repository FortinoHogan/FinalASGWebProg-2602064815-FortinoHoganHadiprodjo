@extends('layouts.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="bg-light p-5 mx-auto flex-grow" style="max-width: 1200px">
        <h6>@lang('lang.your_coin'): {{ $user->coins }}</h6>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($avatars as $avatar)
                @if ($avatar->id > 3)
                    <a href="{{ route('avatar.purchase', ['avatar_id' => $avatar->id]) }}" class="col text-decoration-none">
                        <div class="card text-center p-3 border-0 shadow-sm">
                            <img src="data:image/jpeg;base64,{{ base64_encode($avatar->image) }}" alt="Avatar Image"
                                class="card-img-top mx-auto rounded-circle"
                                style="width: 100px; height: 100px; object-fit: contain; border: 2px solid #ddd;">
                            <div class="card-body d-flex items-center justify-content-center gap-2">
                                <p class="card-text fw-bold mb-0">{{ $avatar->price }} Coin</p>
                                @if ($transactions->contains('avatar_id', $avatar->id))
                                    <p class="card-text fw-bold text-success mb-0">(Purchased)</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endsection
