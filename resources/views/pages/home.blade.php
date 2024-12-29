@extends('layouts.master')

@section('content')
    <div class="d-flex align-items-center justify-content-end mb-5 gap-3">
        <div class="d-flex justify-content-end">
            <form action="" class="position-relative">
                <input class="form-control form-control-sm border-2 border-secondary rounded-2" type="text" name="search"
                    placeholder="Search" value="{{ request('search') }}"
                    style="width: 300px; padding-left: 15px; height: 50px">
                <input type="hidden" name="filter" value="{{ request('filter') }}">
                <button type="submit" class="position-absolute top-50 end-0 translate-middle-y btn btn-outline-secondary">
                    <svg class="text-muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.966 56.966" width="25px"
                        height="35px">
                        <path
                            d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23 s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92 c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17 s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </button>
            </form>
        </div>

        <div class="d-flex justify-content-end position-relative">
            <i class="fa-solid fa-filter" style="font-size: 1.5rem; cursor: pointer;" id="filterDropdownToggle"
                data-bs-toggle="dropdown" aria-expanded="false">
            </i>

            <div class="dropdown-menu dropdown-menu-end p-3 shadow" aria-labelledby="filterDropdownToggle" style="width: 300px">
                <form action="">
                    <div class="mb-3">
                        <label class="form-label">@lang('lang.gender')</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="male" id="genderMale" name="gender[]"
                                {{ in_array('male', request('gender', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderMale">@lang('lang.male')</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="female" id="genderFemale" name="gender[]"
                                {{ in_array('female', request('gender', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderFemale">@lang('lang.female')</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">@lang('lang.field_of_work')</label>
                        @foreach ($fields as $field)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $field->name }}"
                                    id="field{{ $field->id }}" name="field[]"
                                    {{ in_array(($field->name), request('field', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="field{{ $field->id }}">{{ $field->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <button type="submit" class="btn btn-primary btn-sm w-100">@lang('lang.apply_filter')</button>
                </form>
            </div>
        </div>
    </div>
    <div
        class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-4 mb-md-8 gap-4 d-flex justify-content-around">
        @foreach ($users as $u)
            @if (!Auth::check())
                <div class="card col" style="width: 16rem;">
                    <img src="{{ $u->profile_picture ?? asset('assets/img/profile.png') }}"
                        class="card-img-top cursor-pointer" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($u->name, 18, '...') }}</h5>
                        <h6>{{ $u->profession->name }}</h6>
                        @foreach ($u->userFields as $uf)
                            <p class="mb-1">{{ $uf->fieldOfWork->name }}</p>
                        @endforeach
                        <div class="d-flex justify-content-end">
                            <i class="fa-regular fa-thumbs-up" style="font-size: 1.5rem; cursor: pointer;"></i>
                        </div>
                    </div>
                </div>
            @elseif ($u->id != auth()->user()->id)
                <div class="card col" style="width: 16rem;">
                    <img src="{{ $u->profile_picture ?? asset('assets/img/profile.png') }}"
                        class="card-img-top cursor-pointer" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($u->name, 18, '...') }}</h5>
                        <h6>{{ $u->profession->name }}</h6>
                        @foreach ($u->userFields as $uf)
                            <p class="mb-1">{{ $uf->fieldOfWork->name }}</p>
                        @endforeach
                        <div class="d-flex justify-content-end">
                            @if (Auth::user()->friends()->where('friend_id', $u->id)->where('status', 'accepted')->exists() ||
                                    Auth::user()->friends()->where('user_id', $u->id)->where('status', 'accepted')->exists())
                                <i class="fa-solid fa-thumbs-up" style="font-size: 1.5rem; cursor: pointer;"></i>
                            @elseif (Auth::user()->friends()->where('friend_id', $u->id)->where('status', 'pending')->exists() ||
                                    Auth::user()->friends()->where('user_id', $u->id)->where('status', 'pending')->exists())
                                <i class="fa-regular fa-clock" style="font-size: 1.5rem; cursor: pointer;"></i>
                            @else
                                <i class="fa-regular fa-thumbs-up" style="font-size: 1.5rem; cursor: pointer;"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
            dropdown.addEventListener('click', event => {
                event.stopPropagation();
            });
        });
    </script>
@endsection
