<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\Course;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\ModelsInterface\CourseRepositoryInterface;
use Yajra\DataTables\DataTables;

class CourseEloquentRepository extends EloquentRepository implements CourseRepositoryInterface
{
    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        $model = Course::class;
        return $model;
    }

    // get course records
    public function jsonCourses()
    {
        try {
            $data = $this->model::select('*');

            return DataTables::of($data)->addIndexColumn()->toJson();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // store record
    public function storeCourseJSON($request)
    {
        try {
            if (isset($request['record_id'])) {
                $course = $this->findById($request['record_id']);

                return $this->update($request, $course);
            }

            return $this->create($request);
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get course list for lesson
    public function getCourseList()
    {
        try {
            return $this->model::doesnthave('lesson')->get();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get all courses
    public function getAllCourses()
    {
        try {
            return $this->model->countInfo()->paginate(config('const.pagination.course'));
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get top courses
    public function getPopularCourses()
    {
        try {
            return $this->model->countInfo()
                ->orderBy('users_count', 'desc')
                ->take(config('const.pagination.course'))
                ->get();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get course detail and words
    public function getCourseDetail($courseId)
    {
        try {
            $result = $this->findById($courseId)->words()->where('course_id', $courseId)
                            ->paginate(config('const.pagination.course_word'));

            return $result;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - user learn course
    public function learnCourse($userId, $courseId)
    {
        try {
            $course = $this->findById($courseId);
            $result = $course->users()->wherePivot('user_id', $userId)
                            ->wherePivot('course_id', $courseId)->exists();

            if (! $result) {
                return $course->users()->attach($userId);
            }

            return false;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }
}

