<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Repositories\ModelsInterface\QuestionRepositoryInterface;

class QuestionController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function index()
    {
        return view('back-end.questions.index');
    }

    public function getListQuestions()
    {
        $questions = $this->questionRepository->getListQuestions();

        return response()->json($questions, 200);
    }

    public function getAllLesson()
    {
        $lessons = $this->questionRepository->getAllLesson();

        return response()->json($lessons, 200);
    }

    public function edit($id)
    {
        $question = $this->questionRepository->getQuestionById($id);

        return response()->json($question['questionDetails'], $question['statusCode']);
    }

    public function store(QuestionRequest $request)
    {
        $result = $this->questionRepository->createQuestionAndOptions($request);

        return response()->json($result['questionAndOptions'], $result['statusCode']);
    }

    public function update(QuestionRequest $request, $id)
    {
        $result = $this->questionRepository->updateQuestionAndOptions($request, $id);

        return response()->json($result['questionAndOptions'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->questionRepository->deleteQuestion($id);

        return response()->json($result['message'], $result['statusCode']);
    }

}
