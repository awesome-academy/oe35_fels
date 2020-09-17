@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @lang('messages.notify.title_email')
        @endcomponent
    @endslot

{{-- Body --}}
    <p>@lang('messages.front_end.fels.course'):
        <a href="{{ route('fels.course.detail', $course) }}">
            <strong>{{ $course->name }}</strong>
        </a>
    </p>
    <br>
    <p>@lang('messages.notify.description'):
        <i>{{ $course->description }}</i>
    </p>

{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}.
        @endcomponent
    @endslot
@endcomponent
