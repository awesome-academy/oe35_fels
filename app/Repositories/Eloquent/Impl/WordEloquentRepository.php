<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\Word;
use App\Models\Course;
use App\Repositories\ModelsInterface\WordRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class WordEloquentRepository extends EloquentRepository implements WordRepositoryInterface
{
    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        $model = Word::class;
        return $model;
    }

    public function getAllWord()
    {
        try {
            $words = $this->model->latest()->paginate(config('const.pagination.word'));

            return $words;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    public function checkWordIsLearn()
    {
        try {
            $wordUser = Auth::user()->words;
            $checkWordIds = [];

            foreach ($wordUser as $item) {
                array_push($checkWordIds, $item->pivot->word_id);
            }

            return $checkWordIds;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    public function getCourseList()
    {
        try {
            $courseList = Course::select('*')->orderBy('name', config('const.order_course'))->get();

            return $courseList;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    public function filterWord($request)
    {
        try {
            $wordChecks = $this->checkWordIsLearn();
            $words = $this->model::query()
            ->course($request)
            ->learned($request, $wordChecks)
            ->notDone($request, $wordChecks)
            ->desc($request)
            ->asc($request);

            return $words->paginate(config('const.pagination.word'));
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get word records
    public function jsonWords()
    {
        try {
            $data = $this->model::select('*')->with('course:id,name');
            return DataTables::of($data)->addIndexColumn()->toJson();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // store record
    public function storeWordJSON($request)
    {
        try {
            if (isset($request['record_id'])) {
                $word = $this->findById($request['record_id']);

                return $this->update($request, $word);
            }

            return $this->create($request);
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get course name
    public function getCourseName($wordId)
    {
        try {
            $word = $this->findById($wordId);
            $data = $word->course()->select('name')->get();

            return $data;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }
}
