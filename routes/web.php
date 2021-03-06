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

// Socialite Login
Route::get('/auth/{driver}', 'Auth\SocialController@redirectToProvider')->name('social.redirect');
Route::get('/callback/{driver}', 'Auth\SocialController@handleProviderCallback')->name('social.callback');

Route::post('/lang', 'LocaleController')->name('locale');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Admin Management

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::resource('courses', 'CourseController');

    // get course list for lesson
    Route::get('/courses-list', 'CourseController@getCourseList')->name('courses.list');

    Route::resource('lessons', 'LessonController');

    Route::get('/users/index', 'UserController@index')->name('users-list');
    Route::delete('/users/delete/{id}', 'UserController@deleteUser')->name('users-delete');
    Route::patch('/users/restore/{id}', 'UserController@restoreUser')->name('users-restore');

    Route::resource('question', 'QuestionController');
    Route::get('/questions/list', 'QuestionController@getListQuestions');
    Route::get('/questions/all-lesson', 'QuestionController@getAllLesson');

    Route::resource('words', 'WordController');

    // notification
    Route::post('/send-notify', 'NotifyCourseController@sendNotify')->name('notify-course');
    Route::post('/notify/read-all/{userId}', 'NotifyCourseController@markReadNotify')->name('notify-read-all');

    //Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/chart-data', 'DashboardController@getChartData')->name('chart-data');
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

    // Statistics
    Route::group(['as' => 'fels.statistic.'], function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/statistic', [
                'uses' => 'StatisticController@showStatistics',
                'as' => 'statistic',
            ]);

            Route::get('/statistic/chart-data', [
                'uses' => 'StatisticController@getChartData',
                'as' => 'chart-data',
            ]);
        });
    });
});
