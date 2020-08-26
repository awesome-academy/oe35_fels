@extends('layouts.master')

@section('title', $courseName)

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
                <div class="panel_title"></div>
                <div class="panel_text"></div>
                <div class="curriculum_items">
                    <div class="cur_item">
                        <div
                            class="cur_title_container d-flex flex-row align-items-start justify-content-start">
                        <div class="cur_title">{{ $courseName }}</div>
                            <div class="cur_num ml-auto">#Result (x/y)</div>
                        </div>
                        @forelse ($words as $word)
                        <div class="cur_item_content">
                            <div>
                                <ul>
                                    <li class="d-flex flex-row align-items-center justify-content-start">
                                        <div class="cur_item_title">{{ $word->name }}</div>
                                        <div class="cur_time ml-auto">
                                        @if ($word->is_learned == '1')
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
