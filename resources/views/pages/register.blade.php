@extends('layouts.master')

@section('content')
    <div class="bg-light p-4 mx-auto" style="max-width: 340px;">
        <h2 class="text-center my-5">@lang('lang.register')</h2>
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
        <form action="{{ route('register_post') }}" method="POST" class="d-flex flex-column gap-3">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="test123@gmail.com"
                    value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="name">@lang('lang.name')</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="John"
                    value="{{ old('name') }}">
            </div>
            <div class="form-group position-relative">
                <label for="gender">Gender</label>
                <select class="form-control pe-5" id="gender" name="gender" style="cursor: pointer">
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }} >@lang('lang.male')</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }} >@lang('lang.female')</option>
                </select>
                <div class="position-absolute translate-middle-y end-0 px-2" style="top: 60%">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" fill="black">
                        <path d="M12 19l-7-7h14z" />
                    </svg>
                </div>
            </div>
            <div class="form-group">
                <label for="fields" class="form-label">@lang('lang.field_of_work')</label>
                <div class="dropdown w-100">
                    <button
                        class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center"
                        type="button" id="dropdownButton">
                        @lang('lang.field_of_work_placeholder')
                        <span class="ml-2 text-muted">+</span>
                    </button>
                    <div class="dropdown-menu w-100" id="dropdownMenu" aria-labelledby="dropdownButton"
                        style="display: none;">
                        <div class="p-2 max-height-60 overflow-auto">
                            @foreach ($fields as $field)
                                <label class="d-flex align-items-center mb-2">
                                    <input type="checkbox" name="fields[]" value="{{ $field->id }}"
                                        class="form-check-input me-2" style="cursor: pointer"
                                        {{ in_array($field->id, old('fields', [])) ? 'checked' : '' }}>
                                    {{ $field->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group position-relative">
                <label for="profession">@lang('lang.profession')</label>
                <select class="form-control pe-5" id="profession" name="profession" style="cursor: pointer">
                    @foreach ($professions as $profession)
                        <option value="{{ $profession->id }}" {{ old('profession') == $profession->id ? 'selected' : '' }}>
                            {{ $profession->name }}
                        </option>
                    @endforeach
                </select>
                <div class="position-absolute translate-middle-y end-0 px-2" style="top: 60%">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" fill="black">
                        <path d="M12 19l-7-7h14z" />
                    </svg>
                </div>
            </div>
            <div class="form-group">
                <label for="linkedin">Linkedin</label>
                <input type="text" class="form-control" id="linkedin" name="linkedin"
                    placeholder="https://www.linkedin.com/in/username" value="{{ old('linkedin') }}">
            </div>
            <div class="form-group">
                <label for="phone">@lang('lang.phone_number')</label>
                <input type="text" class="form-control" id="phone" name="phone_number" placeholder="08XXXXXXXXX"
                    value="{{ old('phone_number') }}">
            </div>
            <div class="form-group">
                <label for="experience">@lang('lang.experience')</label>
                <input type="number" class="form-control" id="experience" name="experience" placeholder="5"
                    value="{{ old('experience') }}">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="price">@lang('lang.price')</label>
                <input type="text" disabled class="form-control" id="price" name="price" value="">
            </div>
            <input type="hidden" name="price" id="hidden-price">
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">@lang('lang.submit')</button>
            </div>
        </form>
        <div class="mt-3">
            <span class="border-top border-2 p-3 d-flex justify-content-center align-items-center">
                <a href="{{ route('login') }}" class="text-decoration-none text-dark">@lang('lang.login_account')</a>
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

        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const randomPrice = Math.floor(Math.random() * (125000 - 100000 + 1)) + 100000;

        document.getElementById('price').value = randomPrice;
        document.getElementById('hidden-price').value = randomPrice;

        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
        });

        document.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });

        function toggleModal(isVisible) {
            const modal = document.getElementById('modalWrapper');
            if (isVisible) {
                modal.style.display = 'flex';
            } else {
                modal.style.display = 'none';
            }
        }

        function closeModal() {
            toggleModal(false);
        }

        function stopPropagation(event) {
            event.stopPropagation();
        }
    </script>
@endsection
