@extends('layouts.master')

@section('title', trans('messages.front_end.fels.result_page'))

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
                <div class="panel_title">{{ $lessonName }}</div>
                <div class="panel_text"></div>
                <div class="curriculum_items">
                    <div class="cur_item">
                        <div class="cur_title_container"></div>
                        @forelse ($results as $lesson)
                        <div class="cur_item_content">
                            <div class="cur_item_title"></div>
                            <div class="cur_item_text"></div>
                            <div class="cur_contents">
                                <ul>
                                    <li class="d-flex flex-row align-items-center justify-content-start">
                                        <div>
                                            <span class="cur_title">{{ $lesson->pivot->score }}/{{ $totalQuestion }}</span>
                                        </div>
                                        <div class="cur_time ml-auto cur_item_title">
                                            <span>{{ customDateFormat($lesson->pivot->created_at) }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @empty
                            <div class="col">
                                <h5 class="section_title text-center">@lang('messages.front_end.fels.not_found')</h5>
                            </div>
                        @endforelse
                        <!-- Pagination -->
                        @if ($results->isNotEmpty())
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                {!! $results->links() !!}
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