<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    <div class="menu_close_container">
        <div class="menu_close">
            <div></div>
            <div></div>
        </div>
    </div>
    <nav class="menu_nav">
        <ul class="menu_mm">
            <li class="active"><a href="{{ route('homepage') }}">@lang('messages.front_end.nav.home')</a></li>
            <li><a href="{{ route('fels.course.list') }}">@lang('messages.front_end.nav.courses')</a></li>
            @auth
            <li><a href="#">@lang('messages.front_end.nav.word_list')</a></li>
            <li><a href="{{ route('fels.lesson.start') }}">@lang('messages.front_end.nav.start_lesson')</a></li>
            <li><a href="{{ route('fels.statistic.statistic') }}">@lang('messages.front_end.nav.storyboard')</a></li>
            @endauth
        </ul>
    </nav>
</div>
