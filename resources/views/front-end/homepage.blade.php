@extends('layouts.master')

@section('content')
<div class="courses">
    <div class="courses_background"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">Popular Online Courses</h2>
            </div>
        </div>
        <div class="row courses_row">
            <!-- Course -->
            <!-- Using forelse loop to render data -->
            <div class="col-lg-4 course_col">
                <div class="course">
                    <div class="course_image"><img src="{{ asset('img/course.jpg') }}" alt=""></div>
                    <div class="course_body">
                        <div class="course_title"><a href="course.html">Vocabulary</a></div>
                        <div class="course_info">
                        </div>
                        <div class="course_text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
                        </div>
                    </div>
                    <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                        <div class="course_students"><i class="fa fa-user"
                            aria-hidden="true"></i><span>10</span>
                        </div>
                        <div class="course_rating ml-auto"><i class="fa fa-list"
                            aria-hidden="true"></i><span>14</span>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Pagination -->
        <!-- Using links() method-->
        </div>
    </div>
</div>
@endsection
