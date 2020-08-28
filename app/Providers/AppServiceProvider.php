<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\ModelsInterface\QuestionRepositoryInterface::class,
            \App\Repositories\Eloquent\Impl\QuestionRepositoryImpl::class,
        );

        $this->app->singleton(
            \App\Repositories\ModelsInterface\CourseRepositoryInterface::class,
            \App\Repositories\Eloquent\Impl\CourseEloquentRepository::class,
        );

        $this->app->singleton(
            \App\Repositories\ModelsInterface\LessonRepositoryInterface::class,
            \App\Repositories\Eloquent\Impl\LessonEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ModelsInterface\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\Impl\UserEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
