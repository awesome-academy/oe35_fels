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
}
