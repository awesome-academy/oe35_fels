<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'homepage',
    'uses' => 'Fels\CourseController@getPopularCourses',
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Admin Management

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::resource('courses', 'CourseController');

    // get course list for lesson
    Route::get('/courses-list', 'CourseController@getCourseList')->name('courses.list');

    Route::resource('lessons', 'LessonController');

    Route::resource('question', 'QuestionController');
    Route::get('/questions/list', 'QuestionController@getListQuestions');
    Route::get('/questions/all-lesson', 'QuestionController@getAllLesson');
});

// E-learning

Route::group(['namespace' => 'Fels'], function () {
    // Courses
    Route::group(['as' => 'fels.course.'], function () {
        Route::get('/courses', [
            'uses' => 'CourseController@getAllCourses',
            'as' => 'list',
        ]);

        Route::group(['middleware' => ['auth']], function () {
            Route::get('/course/{course}', [
                'uses' => 'CourseController@getCourseInfo',
                'as' => 'detail',
            ]);

            Route::post('/remember-word/{wordId}', [
                'uses' => 'CourseController@rememberWord',
                'as' => 'remember',
            ]);
        });
    });

    // Lesson
    Route::group(['as' => 'fels.lesson.', 'middleware' => ['auth']], function () {
        Route::get('/lesson/start', [
            'uses' => 'LessonController@chooseCourseFirst',
            'as' => 'start',
        ]);

        Route::get('/lesson/exam/{course}', [
            'uses' => 'LessonController@getExamLesson',
            'as' => 'exam',
        ]);

        Route::post('/lesson/exam/check', [
            'uses' => 'LessonController@checkExamLesson',
            'as' => 'check',
        ]);

        Route::get('/lesson/exam/result/{lesson}', [
            'uses' => 'LessonController@getResultLessons',
            'as' => 'result',
        ]);
    });

    // User
    Route::group(['as' => 'fels.user.'], function () {
        Route::get('/user/{user}', [
            'uses' => 'UserController@getProfile',
            'as' => 'profile',
        ]);

        Route::group(['middleware' => ['auth']], function () {
            Route::put('/user/update-info', [
                'uses' => 'UserController@updateInfo',
                'as' => 'update-info',
            ]);

            Route::put('/user/update-password', [
                'uses' => 'UserController@updatePassword',
                'as' => 'update-password',
            ]);
        });
    });

    //word
    Route::group(['as' => 'fels.word.', 'middleware' => ['auth']], function () {
        Route::get('/word', [
            'uses' => 'WordPageController@index',
            'as' => 'index',
        ]);

        Route::post('/word/filter', [
            'uses' => 'WordPageController@filterWord',
            'as' => 'filter',
        ]);
    });
});
