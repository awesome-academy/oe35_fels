@extends('back-end.layouts.master')

@section('title', trans('messages.back_end.dashboard_title'))

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
        integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
        crossorigin="anonymous" />
@endpush

@section('content-header')
<h2>@lang('messages.back_end.dashboard_title')</h2>
@endsection

@section('content')
<!-- Info boxes -->
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">@lang('messages.back_end.dashboard.total_course')</span>
            <span class="info-box-number">{{ $totalCourse }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tasks"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">@lang('messages.back_end.dashboard.total_lesson')</span>
            <span class="info-box-number">{{ $totalLesson }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->

<!-- fix for small devices only -->
<div class="clearfix hidden-md-up"></div>

<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-layer-group"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">@lang('messages.back_end.dashboard.total_word')</span>
            <span class="info-box-number">{{ $totalWord }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">@lang('messages.back_end.dashboard.total_user')</span>
            <span class="info-box-number">{{ $totalUser }}</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
@endsection

@section('sub-content')
<div class="row">
    <!-- Left col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">@lang('messages.chart.title')</h5>

                <div class="card-tools">
                    <select id="select-datetime">
                        <option value="month">@lang('messages.chart.month')</option>
                        <option value="quarter">@lang('messages.chart.quarter')</option>
                        <option value="year">@lang('messages.chart.year')</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center">
                            <strong>@lang('messages.chart.text')</strong>
                        </p>

                        <div class="chart">
                            <canvas id="userChart" height="100" style="height: 100px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right col -->
    <div class="col-md-3">
        <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="fas fa-user-check"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('messages.back_end.dashboard.total_active_user')</span>
                <span class="info-box-number">{{ $totalActiveUser }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>

        <!-- /.info-box -->
        <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="far fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('messages.back_end.dashboard.total_admin')</span>
                <span class="info-box-number">{{ $totalAdmin }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
    integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg=="
    crossorigin="anonymous"></script>
<script src="{{ asset('js/userChart.js') }}"></script>
@endpush
