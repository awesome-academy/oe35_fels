@extends('back-end.layouts.master')

@section('title', trans('messages.back_end.word_title'))

@section('content-header')
    <h2>@lang('messages.back_end.word_title')</h2>
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
                                <th>@lang('messages.modal.form.mean')</th>
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
@include('back-end.words.modal')

@push('js')
    <script src="{{ asset('js/ajaxWord.js') }}"></script>
@endpush
