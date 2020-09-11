@extends('back-end.layouts.master')

@section('title', trans('messages.back_end.question_title'))

@section('content-header')
<h2>@lang('messages.back_end.question_title')</h2>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
@endpush
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <!-- Button -->
            <div class="mb-3 float-left">
                <a href="javascript:void(0)" onclick="question.showAddQuestionModal()" class="btn btn-primary"
                    id="create_new_record"><i class="fa fa-plus"></i> @lang('messages.dataTables.add')</a>
            </div>
            <!-- /Button -->
        </div>
        <div class="card-body">
            <!-- DataTable-->
            <div class="table-responsive">
                <div class="justify-content-center text-center">
                    <table class="table table-striped table-hover" id="tbQuestion">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Option correct</th>
                                <th>Created at</th>
                                <th>Action</th>
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
@include('back-end.questions.addModal')
@include('back-end.questions.editModal')

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="{{ asset('js/question.js') }}"></script>
@endpush