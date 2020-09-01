@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/word.css') }}">
@endpush

@section('content')
<div class="container-fluid word-list-table">
    <div class="row">
        <div class="col-md-3">
            <div class="p-3 user-profile">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('images/img-user.png') }}" class="card-img-user img-thumbnail rounded-circle" alt="user">
                </div>
                <div class="d-md-flex justify-content-between follow-status">
                    <a href="#" class="btn btn-outline-secondary">Follower</a>
                    <span></span>
                    <a href="#" class="btn btn-outline-success">Following</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">  
            <form action="{{ route('fels.word.filter') }}" id="form-order" method="POST">
            <div class="word-header d-flex align-items-center">
                @csrf
                <div class="p-2 title">
                    <a href="{{ route('fels.word.index') }}" type="button" class="btn btn-outline-primary active">ALL WORDS</a>
                </div>
                <div class="list-course">
                    <select name="course" id="course" class="form-control">
                        <option value="" selected>@lang('messages.front_end.fels.option_course')</option>
                        @foreach ($courseList as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="p-2 filter-word">
                    <select type="text" name="orderByLearn" id="orderByLearn" class="form-control">
                        <option value="" selected>@lang('messages.front_end.fels.select')</option>
                        <option value="is_learned">@lang('messages.front_end.fels.learned')</option>
                        <option value="not_done">@lang('messages.front_end.fels.not_done')</option>
                    </select>
                </div>
                <div class="p-2 filter-word">
                    <select type="text" name="orderByName" id="orderByName" class="form-control">
                        <option value="" selected>@lang('messages.front_end.fels.select')</option>
                        <option value="asc"> A-z</option>
                        <option value="desc"> Z-a</option>
                    </select>
                </div>
                <div class="submit">
                    <input type="submit" class="btn btn-dark" value="@lang('messages.front_end.fels.filter')">
                </div>
            </div>
            </form>
            <br>
            <div class="word-list" id="table-word-list">
                <table class="table table-sm table-responsive-sm">
                    <caption>@lang('messages.front_end.fels.caption_table_word')</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('messages.front_end.fels.word')</th>
                            <th scope="col">@lang('messages.front_end.fels.mean')</th>
                            <th scope="col">@lang('messages.front_end.fels.course')</th>
                            <th scope="col">@lang('messages.front_end.fels.status')</th>
                        </tr>
                    </thead>
                    <tbody id="tb-word-list">
                        @if (count($words) == 0)
                            <tr>
                                <td colspan="4">@lang('messages.front_end.fels.no_data')</td>
                            </tr>
                        @else
                        @foreach ($words as $word)
                        <tr>
                            <th scope="row">{{ $word->id }}</th>
                            <td>{{ $word->name }}</td>
                            <td>{{ $word->mean }}</td>
                            <td>{{ $word->course->name }}</td>
                            <td>
                                @if (in_array($word->id, $checkWordIds))
                                    {!! '<p class="text-success">Learned</p>' !!}
                                @else
                                    {!! '<p class="text-danger">Not</p>' !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                        @endif
                    </tbody>
                </table>
                <div id="page" class="align-items-center">
                    {!! $words->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
