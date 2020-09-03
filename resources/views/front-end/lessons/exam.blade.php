@extends('layouts.master')

@section('title', $lesson->name)

@push('css')
<!-- CSS Course detail page -->
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
@endpush

@section('content')
<div class="course">
    <div class="container">
        <div class="row">
            <!-- Curriculum -->
            <div class="curriculum tab_panel">
                <div class="panel_title"></div>
                <div class="panel_text"></div>
                <div class="curriculum_items">
                    <div class="cur_item">
                        <div class="cur_title_container d-flex flex-row align-items-start justify-content-start">
                            <div class="cur_title">{{ $lesson->name }}</div>
                            <div class="cur_num ml-auto">
                                <span>@lang('messages.front_end.exam.time_left')</span>
                                <span id="clock" class="cur_item_title"></span>
                            </div>
                        </div>
                        <form action="{{ route('fels.lesson.check') }}" method="post" id="lessonForm">
                            @csrf
                            @forelse ($lesson->questions as $question)
                            <div class="cur_item_content">
                                <div class="cur_item_title">{{ $question->name }}</div>
                                    <div class="cur_contents">
                                        <ul>
                                            @forelse ($question->options as $option)
                                            <li class="d-flex flex-row align-items-center justify-content-start">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="answer[{{ $option->question_id }}]"
                                                        id="{{ $option->id }}" value="{{ $option->id }}">
                                                    <label class="form-check-label" for="{{ $option->id }}">
                                                        {{ $option->name }}
                                                    </label>
                                                </div>
                                            </li>
                                            @empty
                                            <li class="d-flex flex-row align-items-center justify-content-start">
                                                <div>
                                                    <span>@lang('messages.front_end.fels.not_found')</span>
                                                </div>
                                            </li>
                                            @endforelse
                                        </ul>
                                    </div>
                            </div>
                            @empty
                                <div class="col">
                                    <h5 class="section_title text-center">@lang('messages.front_end.fels.not_found')</h5>
                                </div>
                            @endforelse
                            <div>
                                <input type="hidden" name="lessonId" value="{{ $lesson->id }}">
                            </div>
                            <div class="cur_contents clearfix">
                                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        var time = {{ config('const.exam_time') }};
        var lessonFormId = 'lessonForm';
        var clockId = 'clock';
        var swalTitle = '{{ trans('messages.front_end.exam.time_up') }}';
        var swalText = '{{ trans('messages.front_end.exam.submit_text') }}';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('js/timer.js') }}"></script>
@endpush
