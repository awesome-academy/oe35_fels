<header class="header">
    <!-- Header Content -->
    <div class="header_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justify-content-start">
                        <div class="logo_container mr-auto">
                            <a href="{{ route('homepage') }}">
                                <div class="logo_text">{{ config('app.name') }}</div>
                            </a>
                        </div>
                        <nav class="main_nav_contaner">
                            <ul class="main_nav">
                            <li class="active"><a href="{{ route('homepage') }}">@lang('messages.front_end.nav.home')</a></li>
                                <li><a href="{{ route('fels.course.list') }}">@lang('messages.front_end.nav.courses')</a></li>
                                @auth
                                <li><a href="{{ route('fels.word.index') }}">@lang('messages.front_end.nav.word_list')</a></li>
                                <li><a href="{{ route('fels.lesson.start') }}" >@lang('messages.front_end.nav.start_lesson')</a></li>
                                <li><a href="{{ route('fels.statistic.statistic') }}">@lang('messages.front_end.nav.storyboard')</a></li>
                                @endauth
                            </ul>
                        </nav>
                        <div class="header_content_right ml-auto text-right">
                            <div class="d-flex flex-col align-items-start justify-content-start">
                                <!-- Notification -->
                                @auth
                                <div id="notify-data">
                                @php
                                    $user = Auth::user();
                                    $unreadNotifyCount = $user->unreadNotifications->count();
                                    $adminRole = [config('const.role.admin'), config('const.role.super_admin')];
                                @endphp
                                </div>
                                <div class="align-items-center">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="notification"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-bell" aria-hidden="true"></i>
                                            <span class="badge badge-danger badge-counter" id="notify-count">
                                                {{ $unreadNotifyCount }}
                                            </span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="notification">
                                            <h6 class="dropdown-header">
                                                <p class="small">
                                                    @lang('messages.notify.title')
                                                </p>
                                            </h6>
                                            <div class="dropdown-divider"></div>
                                            <div id="notify-content">
                                                @foreach ($user->unreadNotifications as $notification)
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        <div class="ml-3">
                                                            <a href="{{ route('fels.course.detail', $notification->data['name']) }}">
                                                                <span class="font-weight-bold">
                                                                    {{ $notification->data['name'] }}
                                                                </span>
                                                            </a>
                                                            <div class="small text-gray-500">
                                                                {{ customDateFormat($notification->created_at) }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div id="notify-footer">
                                                @if ($unreadNotifyCount > 0)
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-center small"
                                                    href="javascript:void(0)" onclick="markAllReadNotify({{ $user->id }});">
                                                        @lang('messages.notify.mark_all_read')
                                                    </a>
                                                @else
                                                    <p class="text-center small">
                                                        @lang('messages.notify.no_notify')
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endauth

                                <!-- Hamburger -->
                                <div class="account col align-items-center">
                                    <div>
                                        <form method="POST" action="{{ route('locale') }}">
                                            @csrf
                                            @php
                                                $en = config('const.locale.en');
                                                $vi = config('const.locale.vi');
                                            @endphp
                                            <select onchange="this.form.submit()" name="locale">
                                                <option value="{{ $en }}"
                                                    {{ app()->isLocale($en) ? 'selected' : '' }}>
                                                    @lang('messages.locale.en')
                                                </option>
                                                <option value="{{ $vi }}"
                                                    {{ app()->isLocale($vi) ? 'selected' : '' }}>
                                                    @lang('messages.locale.vi')
                                                </option>
                                            </select>
                                        </form>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="userName"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">@lang('messages.front_end.nav.account')</a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
                                            @guest
                                                <a class="dropdown-item" href="{{ route('login') }}">@lang('messages.login')</a>
                                                @if (Route::has('register'))
                                                    <a class="dropdown-item" href="{{ route('register') }}">@lang('messages.register')</a>
                                                @endif
                                            @else
                                            @if (in_array($user->role_id, $adminRole))
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                @lang('messages.dashboard')</a>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('fels.user.profile', $user->profile) }}">
                                                    @lang('messages.front_end.nav.profile')</a>
                                            <a class="dropdown-item" href="javascript:void(0)" id="btn_logout">@lang('messages.logout')</a>
                                            @endguest
                                        </div>
                                    </div>
                                </div>
                                <div class="hamburger col menu_mm">
                                    <i class="fa fa-bars menu_mm" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
