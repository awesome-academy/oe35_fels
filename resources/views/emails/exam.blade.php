@component('mail::layout')
{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        @lang('messages.mail.title')
    @endcomponent
@endslot

<p>
    <i>@lang('messages.mail.dear')</i>
    <strong>{{ $user->profile->name }},</strong>
</p>

<h4>@lang('messages.mail.text'):</h4>

{{-- Body --}}
@foreach ($courses as $course)
# - [{{ $course->name }}]({{ route('fels.lesson.exam', $course) }})
@endforeach

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
