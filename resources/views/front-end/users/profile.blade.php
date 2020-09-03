@extends('layouts.master')

@section('title', trans('messages.front_end.profile.detail'))

@push('css')
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="profile">
    <div class="container">
        <div class="row row-lg-eq-height">
            <!-- Details -->
            <div class="col-lg-12">
                <div class="profile_details">
                    <div class="profile_details_title">@lang('messages.front_end.profile.detail')</div>
                    <ul>
                        <li>
                            @if (isset(Auth::user()->social))
                            <img src="{{ $profile->avatar }}" alt="">
                            @else
                            <img src="{{ asset('profile/' . $profile->avatar) }}" alt="">
                            @endif
                        </li>
                        <li>
                            <p>@lang('messages.front_end.user.name'): </p>
                            <span>{{ $profile->name }}</span>
                        </li>
                        <li>
                            <p>@lang('messages.front_end.user.email'): </p>
                            <span>{{ $profile->user->email }}</span>
                        </li>
                        <li>
                            <p>@lang('messages.front_end.user.gender'): </p>
                            @if ($profile->gender == config('const.gender.male'))
                                <span>@lang('messages.front_end.gender.male')</span>
                            @elseif($profile->gender == config('const.gender.female'))
                                <span>@lang('messages.front_end.gender.female')</span>
                            @else
                                <span>@lang('messages.front_end.gender.other')</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Form -->
            @auth
            <div class="col-lg-12">
                <div class="tab_panels">
                    <!-- Tabs -->
                    <div class="course_tabs_container">
                        <div class="container">
                            <div class="row">
                                <div class="tabs d-flex flex-row align-items-center justify-content-start">
                                    <div class="tab active">@lang('messages.front_end.profile.update')</div>
                                    <div class="tab">@lang('messages.front_end.user.setting')</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab_panel active">
                        <div class="profile_form_container">
                            <div class="form_title">@lang('messages.front_end.profile.update')</div>
                            @if (isset(Auth::user()->social))
                            <div class="panel_text">@lang('messages.social.social_profile')</div>
                            @else
                            <form action="{{ route('fels.user.update-info') }}" method="POST" class="profile_form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row profile_row">
                                    <div class="col-lg-12 profile_col">
                                        <label for="name">@lang('messages.input_form.name')</label>
                                        <input type="text" class="form_input" id="name" name="name" value="{{ old('name' ?? '') }}">
                                    </div>
                                    <div class="col-lg-12 profile_col">
                                        <label for="email">@lang('messages.input_form.email')</label>
                                        <input type="email" class="form_input" id="email" name="email" value="{{ old('email' ?? '') }}">
                                    </div>
                                    <div class="col-lg-12 profile_col">
                                        <label for="email">@lang('messages.input_form.gender')</label><br>
                                        <input type="radio" id="male" name="gender" value="{{ config('const.gender.male') }}">
                                        <label for="male">@lang('messages.front_end.gender.male')</label><br>
                                        <input type="radio" id="female" name="gender" value="{{ config('const.gender.female') }}">
                                        <label for="female">@lang('messages.front_end.gender.female')</label><br>
                                    </div>
                                    <div class="col-lg-12 profile_col">
                                        <label for="avatar">@lang('messages.input_form.avatar')</label>
                                        <input type="file" class="form-control" id="avatar" name="avatar"
                                            accept="image/*" onchange="loadPreview(this);">
                                    </div>
                                    <div class="col-lg-12 profile_col form-group">
                                        <div>
                                            <img id="preview_img" src="#" alt="image" class="member_image" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="form_button trans_200">
                                            @lang('messages.front_end.user.update_btn')
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="tab_panel">
                        <div class="profile_form_container">
                            <div class="form_title">@lang('messages.front_end.user.setting')</div>
                            <form action="{{ route('fels.user.update-password') }}" method="POST" class="profile_form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row profile_row">
                                    <div class="col-lg-12 profile_col">
                                        <label for="old_password">@lang('messages.input_form.old_password')</label>
                                        <input type="password" class="form_input" id="old_password" name="old_password" required="required">
                                    </div>
                                    <div class="col-lg-12 profile_col">
                                        <label for="password">@lang('messages.input_form.password')</label>
                                        <input type="password" class="form_input" id="password" name="password" required="required">
                                    </div>
                                    <div class="col-lg-12 profile_col">
                                        <label for="confirm_password">@lang('messages.input_form.confirm_password')</label>
                                        <input type="password" class="form_input" id="confirm_password" name="password_confirmation" required="required">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="form_button trans_200">
                                            @lang('messages.front_end.user.update_btn')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('js/profile.js') }}"></script>
    <script src="{{ asset('js/previewImg.js') }}"></script>
@endpush
