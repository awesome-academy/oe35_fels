@extends('back-end.layouts.master')

@section('title', 'Lessons Management')

@section('content-header')
    <h2>Lessons Management</h2>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
        <!-- Button -->
        <div class="mb-3 float-left">
            <a href="javascript:void(0)" class="btn btn-primary" id="create_new_record"><i class="fa fa-plus"></i> @lang('messages.dataTables.add')</a>
        </div>
        <!-- /Button -->
        </div>
        <div class="card-body">
            <!-- DataTable-->
            <div class="table-responsive">
                <div class="justify-content-center text-center">
                    <table class="table table-striped table-hover" id="datatable_record">
                        <thead>
                            <tr>
                                <th>@lang('messages.dataTables.no_index')</th>
                                <th>@lang('messages.dataTables.name')</th>
                                <th>@lang('messages.modal.form.course')</th>
                                <th>@lang('messages.dataTables.created_at')</th>
                                <th>@lang('messages.dataTables.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /DataTable-->
        </div>
    </div>
</div>
@endsection

<!-- Bootstrap modal-->
@include('back-end.lessons.modal')

@push('js')
    <script src="{{ asset('js/ajaxLesson.js') }}"></script>
@endpush
