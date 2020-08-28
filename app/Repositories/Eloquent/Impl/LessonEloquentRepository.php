<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\Lesson;
use App\Models\Option;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\ModelsInterface\LessonRepositoryInterface;
use Illuminate\Support\Facades\Auth;
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

    // e-learning - get exam lesson of course
    public function getLessonOfCourse($courseId)
    {
        try {
            $lesson = $this->model->whereCourseId($courseId)->first();

            return $lesson;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get exam lesson of course
    public function checkResult($request)
    {
        try {
            $lessonId = $request['lessonId'];
            $score = 0;

            foreach ($request['answer'] as $value) {
                $result = Option::select('is_correct')->find($value)->get();
                if ($result->is_correct == '1') {
                    $score++;
                }
            }

            $user = Auth::user();
            $result = $user->lessons()->attach($lessonId, ['score' => $score]);

            return $result;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get highest score of lesson
    public function getHighestScore($lessonId)
    {
        try {
            $user = Auth::user();
            $data = $user->lessons()->wherePivot('lesson_id', $lessonId)
                        ->orderBy('score', config('const.order_score'))->first();
            if ($data == null) {
                return $data;
            }

            $score = $data->pivot->score;

            return $score;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get total question of lesson
    public function getTotalQuestion($lessonId)
    {
        try {
            $lesson = $this->model->whereId($lessonId)->withCount('questions')->first();
            if ($lesson == null) {
                return $lesson;
            }
            $totalQuestion = $lesson->questions_count;

            return $totalQuestion;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // e-learning - get all results of lesson
    public function getResults($lessonId)
    {
        try {
            $user = Auth::user();
            $data = $user->lessons()->wherePivot('lesson_id', $lessonId)
                        ->latest()->paginate(config('const.pagination.course_word'));

            return $data;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }
}
