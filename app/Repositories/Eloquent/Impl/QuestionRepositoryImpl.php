<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\Question;
use App\Models\Lesson;
use App\Models\Option;
use App\Repositories\ModelsInterface\QuestionRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Facades\DB;

class QuestionRepositoryImpl extends EloquentRepository implements QuestionRepositoryInterface
{
    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        $model = Question::class;
        return $model;
    }

    public function getListQuestions()
    {
        try {
            $dataQuestions = $this->model::all();

            //get options 
            foreach ($dataQuestions as $question) {
                $question->options;
            }

            return $dataQuestions;
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }

    public function getAllLesson()
    {
        try {
            $lessons = Lesson::all();
            return $lessons;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    public function createQuestionAndOptions($request)
    {
        try {
            DB::beginTransaction();

            $dataQuestionCreate = [
                'lesson_id' => $request->lessonId,
                'name' => $request->name,
            ];
            //create question
            $question = $this->model->create($dataQuestionCreate);

            $statusCode = 201;

            if (!$question) {
                $statusCode = 500;
            }

            $dataOptionsCreate = [
                [
                    'name' => $request->optionA,
                    'is_correct' => $request->aIsCorrect
                ],
                [
                    'name' => $request->optionB,
                    'is_correct' => $request->bIsCorrect
                ],
                [
                    'name' => $request->optionC,
                    'is_correct' => $request->cIsCorrect
                ],
                [
                    'name' => $request->optionD,
                    'is_correct' => $request->dIsCorrect
                ]
            ];

            //create options for each question
            $options = $question->options()->createMany($dataOptionsCreate);

            if (!$options) {
                $statusCode = 500;
            }

            $data = [
                'statusCode' => $statusCode,
                'questionAndOptions' => [
                    'question' => $question,
                    'options' => $options
                ]
            ];

            DB::commit();

            return $data;
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errroResult($e->getMessage());
        }
    }

    public function getQuestionById($id)
    {
        $questionById = $this->model->findOrFail($id);
        $statusCode = 200;

        $options = $this->getOptionsForeachQuestion($questionById);

        $lessons = $this->getAllLesson();

        if (!$questionById || !$options) {
            $statusCode = 404;
        }

        $data = [
            'statusCode' => $statusCode,
            'questionDetails' => [
                'question' => $questionById,
                'options' => $options,
                'lessonList' => $lessons
            ],
        ];

        return $data;
    }

    private function getOptionsForeachQuestion($questionById)
    {

        $options = $questionById->options()->where('question_id', $questionById->id)->get();

        return $options;
    }

    public function updateQuestionAndOptions($request, $id)
    {
        try {
            DB::beginTransaction();
            $dataQuestionUpdate = [
                'lesson_id' => $request->lessonId,
                'name' => $request->name,
            ];

            $oldQuestion = $this->model->findOrFail($id);
            $statusCode = 200;

            if (!$oldQuestion) {
                $newQuestion = null;
                $statusCode = 404;
            } else {
                $newQuestion = $oldQuestion->update($dataQuestionUpdate);

                $newOptions = $this->updateOptions($request);

                if (!$newOptions || !$newQuestion) {
                    $statusCode = 404;
                }
            }
            $data = [
                'statusCode' => $statusCode,
                'questionAndOptions' => [
                    'newQuestion' => $newQuestion,
                    'newOptions' => $newOptions
                ]
            ];
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errroResult($e->getMessage());
        }
    }

    private function updateOptions($request)
    {
        $dataOptionsUpdate = [
            'optionA' => [
                'name' => $request->optionA,
                'is_correct' => $request->aIsCorrect
            ],
            'optionB' => [
                'name' => $request->optionB,
                'is_correct' => $request->bIsCorrect
            ],
            'optionC' => [
                'name' => $request->optionC,
                'is_correct' => $request->cIsCorrect
            ],
            'optionD' => [
                'name' => $request->optionD,
                'is_correct' => $request->dIsCorrect
            ]
        ];

        $optionA = Option::where('id', $request->optionIdA)->update($dataOptionsUpdate['optionA']);
        $optionB = Option::where('id', $request->optionIdB)->update($dataOptionsUpdate['optionB']);
        $optionC = Option::where('id', $request->optionIdC)->update($dataOptionsUpdate['optionC']);
        $optionD = Option::where('id', $request->optionIdD)->update($dataOptionsUpdate['optionD']);

        $options = [
            'optionA' => $optionA,
            'optionB' => $optionB,
            'optionC' => $optionC,
            'optionD' => $optionD,
        ];

        return $options;
    }

    public function deleteQuestion($id)
    {
        try {
            // DB::beginTransaction();

            $question = $this->model->findOrFail($id);

            $statusCode = 404;
            $message = trans('messages.question.not_found');

            if ($question) {
                $question->delete();
                $statusCode = 200;
                $message = trans('messages.question.success_delete');
            }

            $dataQuestion = [
                'statusCode' => $statusCode,
                'message' => $message
            ];
            // DB::commit();

            return $dataQuestion;
        } catch (\Exception $e) {
            // DB::rollBack();

            return $this->errroResult($e->getMessage());
        }
    }
}
