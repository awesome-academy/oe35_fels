@extends('layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/word.css') }}">
@endpush

@section('content')
<div class="container-fluid word-list-table">
    <div class="row">
        <div class="col-md-3">
            <div class="user-profile">
               
            </div>
        </div>
        <div class="col-md-9">  
            <form action="{{ route('fels.word.filter') }}" id="form-order" method="POST">
            <div class="word-header d-flex align-items-center">
                @csrf
                <div class="p-2 title">
                    <a href="{{ route('fels.word.index') }}" type="button" class="btn btn-outline-primary active">ALL WORDS</a>
                    {{-- <label><h3 class="text-primary">{{ $courseName ?? "" }}</h3></label> --}}
                </div>
                <div class="list-course">
                    <select name="course" id="course" class="form-control">
                        <option value="" selected>Select Course</option>
                        @foreach ($courseList as $item)
                            @if ($item->id == $courseSelected)
                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="p-2 filter-word">
                    <select type="text" name="orderByLearn" id="orderByLearn" class="form-control">
                        <option class="" value="">@lang('messages.front_end.fels.select')</option>
                        <option value="is_learned" @if($orderByLearn === 'is_learned') selected @endif>@lang('messages.front_end.fels.learned')</option>
                        <option value="not_done" @if($orderByLearn === 'not_done') selected @endif>@lang('messages.front_end.fels.not_done')</option>
                    </select>
                </div>
                <div class="p-2 filter-word">
                    <select type="text" name="orderByName" id="orderByName" class="form-control">
                        <option class="" value="">@lang('messages.front_end.fels.select')</option>
                        <option value="asc" @if($orderByName === 'asc') selected @endif> A-z</option>
                        <option value="desc" @if($orderByName === 'desc') selected @endif> Z-a</option>
                    </select>
                </div>
                <div class="submit">
                    <input type="submit" class="btn btn-dark" value="submit">
                </div>
            </div>
            </form>
            <br>
            <div class="word-list" id="table-word-list">
                <table class="table table-sm table-responsive-sm">
                    <caption>List of words</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Word</th>
                            <th scope="col">Mean</th>
                            <th scope="col">Course</th>
                            <th scope="col">Status</th>
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
                                        @if (in_array($word->id, $checkWords))
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
                    {{ $words->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
