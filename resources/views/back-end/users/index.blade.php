@extends('back-end.layouts.master')

@section('title', trans('messages.back_end.user_title'))

@section('content-header')
    <h2>@lang('messages.back_end.user_title')</h2>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
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
                                <th>@lang('messages.dataTables.email')</th>
                                <th>@lang('messages.dataTables.role')</th>
                                <th>@lang('messages.dataTables.status')</th>
                                <th>@lang('messages.dataTables.created_at')</th>
                                <th>@lang('messages.dataTables.updated_at')</th>
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
@include('back-end.users.modal')

@push('js')
    <script src="{{ asset('js/ajaxUser.js') }}"></script>
@endpush
