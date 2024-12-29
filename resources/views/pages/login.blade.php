@extends('layouts.master')

@section('content')
    <div class="bg-light p-4 mx-auto" style="max-width: 340px;">
        <h2 class="text-center my-5">@lang('lang.login')</h2>
        @if ($errors->any() || session()->has('error'))
            <div class="bg-danger p-3 text-white mb-3 d-flex align-items-center justify-content-between" id="errorMsg">
                <span>{{ session('error') ?? $errors->first() }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" id="closeError"
                    fill="#e8eaed" style="cursor: pointer">
                    <path
                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                </svg>
            </div>
        @endif
        <form action="{{ route('login_post') }}" method="POST" class="d-flex flex-column gap-3">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">@lang('lang.submit')</button>
            </div>
        </form>
        <div class="mt-3">
            <span class="border-top border-2 p-3 d-flex justify-content-center align-items-center">
                <a href="{{ route('register') }}" class="text-decoration-none text-dark">@lang('lang.register_account')</a>
            </span>
            <span class="border-top border-2 p-3 d-flex justify-content-center align-items-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark">@lang('lang.back_home')</a>
            </span>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const closeError = document.getElementById("closeError");
            const errorMsg = document.getElementById("errorMsg");

            if (closeError && errorMsg) {
                closeError.addEventListener("click", function() {
                    errorMsg.style.setProperty('display', 'none', 'important');
                });
            }
        });
    </script>
@endsection
