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
                        </div>
                        <form action="{{ route('fels.lesson.check') }}" method="post">
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