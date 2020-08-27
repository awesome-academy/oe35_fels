@extends('layouts.master')

@section('title', $course->name)

@push('css')
<!-- CSS Course detail page -->
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
@endpush

@section('content')
<div class="course">
    {{-- <div class="course_top"></div> --}}
    <div class="container">
        <div class="row">
            <!-- Curriculum -->
            <div class="curriculum tab_panel">
                <div class="panel_title">{{ $course->name }}</div>
                <div class="panel_text"></div>
                <div class="curriculum_items">
                    <div class="cur_item">
                        <div class="cur_title_container d-flex flex-row align-items-start justify-content-start">
                            <div class="cur_title">
                                <a href="{{ route('fels.lesson.exam', $course) }}" class="btn btn-primary">
                                    @lang('messages.front_end.nav.start_lesson')
                                </a>
                            </div>
                            <div class="cur_num ml-auto">
                                <span>@lang('messages.front_end.fels.highest_score'): </span>
                                <span>
                                    {{ $highestScore ?? config('const.n_a') }}/{{ $totalQuestion ?? config('const.n_a') }}
                                </span>
                            </div>
                        </div>
                        @if ($lesson != null)
                            <div class="d-flex flex-row align-items-start justify-content-start">
                                <div class="ml-auto">
                                    <a href="{{ route('fels.lesson.result', $lesson) }}">
                                        @lang('messages.front_end.fels.link_result_page')
                                    </a>
                                </div>
                            </div>
                        @endif
                        @forelse ($words as $word)
                        <div class="cur_item_content">
                            <div>
                                <ul>
                                    <li class="d-flex flex-row align-items-center justify-content-start">
                                        <div class="cur_item_title">{{ $word->name }}</div>
                                        <div class="cur_time ml-auto">
                                        @if ($word->is_learned == config('const.learned'))
                                            <div>
                                                <span>@lang('messages.front_end.fels.learned')</span>
                                                <i class="fas fa-check"></i>
                                            </div>
                                        @else
                                            <div>
                                                <span id="wordNotLearnText-{{ $word->id }}">@lang('messages.front_end.fels.ask_learn')</span>
                                                <button class="btn btn-info" id="wordNotLearnBtn-{{ $word->id }}" onclick="submitWordLearn({{ $word->id }});">
                                                    <i class="fas fa-book-open"></i>
                                                </button>
                                            </div>
                                            <div>
                                                <span id="wordLearned-{{ $word->id }}" hidden>@lang('messages.front_end.fels.learned')</span>
                                                <span id="wordLearnedIcon-{{ $word->id }}" hidden><i class="fas fa-check"></i></span>
                                            </div>
                                        @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="cur_item_text">
                                <p>{{ $word->mean }}</p>
                            </div>
                        </div>
                        @empty
                            <div class="col">
                                <h5 class="section_title text-center">@lang('messages.front_end.fels.not_found')</h5>
                            </div>
                        @endforelse
                        <!-- Pagination -->
                        @if ($words->isNotEmpty())
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                {!! $words->links() !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('js/ajaxFelsWord.js') }}"></script>
@endpush
