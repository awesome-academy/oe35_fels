@extends('layouts.master')

@section('title', trans('messages.front_end.storyboard.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
    <link rel="stylesheet" href="{{ asset('css/storyboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
@endpush

@section('content')
<div class="course">
    <div class="container">
        <div class="row row-lg-eq-height">
            <!-- Panels -->
            <div class="col-lg-9">
                <div class="tab_panels">
                    <!-- Curriculum -->
                    <div class="tab_panel curriculum active">
                        <div class="panel_title">@lang('messages.front_end.storyboard.title')</div>
                        <div class="panel_text"></div>
                        <div class="curriculum_items">
                            <div class="cur_item">
                                <div
                                    class="cur_title_container d-flex flex-row align-items-start justify-content-start">
                                    <div class="cur_title">
                                        @lang('messages.front_end.storyboard.graph_text')
                                    </div>
                                    <div class="cur_num ml-auto"></div>
                                </div>
                                <div class="cur_item_content">
                                    <div class="cur_item_title"></div>
                                    <div class="cur_item_text">
                                        <span>@lang('messages.front_end.storyboard.description')</span>
                                    </div>
                                    <div class="cur_contents">
                                        <canvas id="wordChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="sidebar_content">
                        <!-- Features -->
                        <div class="sidebar_section features">
                            <div class="sidebar_title">
                                @lang('messages.front_end.storyboard.statistics')
                            </div>
                            <div class="features_content">
                                <!-- Info Boxes Style 2 -->
                                <div class="info-box mb-3 bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">
                                            @lang('messages.front_end.storyboard.word_learned')
                                        </span>
                                        <span class="info-box-number">{{ $totalWord->words_count }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                                <div class="info-box mb-3 bg-success">
                                    <span class="info-box-icon"><i class="fas fa-book"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">
                                            @lang('messages.front_end.storyboard.course_learned')
                                        </span>
                                        <span class="info-box-number">{{ $totalCourse->courses_count }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                                <div class="info-box mb-3 bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-tasks"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">
                                            @lang('messages.front_end.storyboard.lesson')
                                        </span>
                                        <span class="info-box-number">{{ $totalLesson->lessons_count }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
    <script src="{{ asset('js/wordChart.js') }}"></script>
@endpush
