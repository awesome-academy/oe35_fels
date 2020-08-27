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
                                <li><a href="#">@lang('messages.front_end.nav.word_list')</a></li>
                                <li><a href="{{ route('fels.lesson.start') }}" >@lang('messages.front_end.nav.start_lesson')</a></li>
                                <li><a href="#">@lang('messages.front_end.nav.storyboard')</a></li>
                                @endauth
                            </ul>
                        </nav>
                        <div class="header_content_right ml-auto text-right">

                            <!-- Hamburger -->
                            <div class="account align-items-center">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="userName"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">@lang('messages.front_end.nav.account')</a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
                                        @guest
                                            <a class="dropdown-item" href="{{ route('login') }}">@lang('messages.login')</a>
                                            @if (Route::has('register'))
                                                <a class="dropdown-item" href="#{{ route('register') }}">@lang('messages.register')</a>
                                            @endif
                                        @else
                                            <a class="dropdown-item" href="#">@lang('messages.front_end.nav.profile')</a>
                                            <a class="dropdown-item" href="javascript:void(0)" id="btn_logout">@lang('messages.logout')</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                            <div class="hamburger menu_mm">
                                <i class="fa fa-bars menu_mm" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
