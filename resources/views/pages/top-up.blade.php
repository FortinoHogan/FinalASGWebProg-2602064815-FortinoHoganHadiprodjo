@extends('layouts.master')

@section('content')
    <div class="bg-light d-flex gap-5 flex-column p-5 mx-auto" style="max-width: 340px">
        <h1 class="text-center">@lang('lang.topup')</h1>
        <h5 class="text-center">Coin: {{ $user->coins }}</h5>
        <form action="{{ route('add-coin') }}" class="">
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">@lang('lang.add_coin')</button>
            </div>
        </form>
    </div>
@endsection
