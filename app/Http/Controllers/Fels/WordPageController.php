<?php

namespace App\Http\Controllers\Fels;

use App\Http\Controllers\Controller;
use App\Repositories\ModelsInterface\CourseRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\ModelsInterface\WordRepositoryInterface;

class WordPageController extends Controller
{
    protected $courseRepository;
    protected $wordRepository;

    public function __construct(WordRepositoryInterface $wordRepository, CourseRepositoryInterface $courseRepository)
    {
        $this->wordRepository = $wordRepository;
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        $words = $this->wordRepository->getAllWord();
        $checkWord = $this->wordRepository->checkWordIsLearn();
        $courseList = $this->wordRepository->getCourseList();
        
        return view('front-end.words.list', [
            'words' => $words,
            'courseList' => $courseList,
            'checkWordIds' => $checkWord
        ]);
    }

    public function filterWord(Request $request)
    {
        $words = $this->wordRepository->filterWord($request);

        if (isset($words['errorMsg'])) {
            return back()->with('error', trans('messages.front_end.fels.word_not_found'));
        }

        $checkWords = $this->wordRepository->checkWordIsLearn();

        $orderByLearn =  $request->orderByLearn;
        $orderByName = $request->orderByName;

        $courseSelected = $request->course;
        $courseList = $this->wordRepository->getCourseList();

        return view('front-end.words.filter', [
            'words' => $words,
            'checkWords' => $checkWords,
            'orderByLearn' => $orderByLearn,
            'orderByName' => $orderByName,
            'courseSelected' => $courseSelected,
            'courseList' => $courseList
        ]);
    }
}
