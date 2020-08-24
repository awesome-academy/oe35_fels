<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\Course;
use App\Models\Lesson;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\ModelsInterface\LessonRepositoryInterface;
use Yajra\DataTables\DataTables;

class LessonEloquentRepository extends EloquentRepository implements LessonRepositoryInterface
{
    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        $model = Lesson::class;
        return $model;
    }

    // get lesson records
    public function jsonLessons()
    {
        try {
            $data = $this->model::select('*')->with('course:id,name');
            return DataTables::of($data)->addIndexColumn()->toJson();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // store record
    public function storeLessonJSON($request)
    {
        try {
            if (isset($request['record_id'])) {
                $lesson = $this->findById($request['record_id']);

                return $this->update($request, $lesson);
            }

            return $this->create($request);
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }
}
