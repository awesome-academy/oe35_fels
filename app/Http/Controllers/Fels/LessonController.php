<?php

namespace App\Http\Controllers\Fels;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Repositories\ModelsInterface\LessonRepositoryInterface;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    private $lessonRepository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    // choose a course to start lesson
    public function chooseCourseFirst()
    {
        return redirect()->route('fels.course.list')
                ->with('error', trans('messages.front_end.fels.choose_lesson'));
    }

    // get exam lesson of course
    public function getExamLesson(Course $course)
    {
        $courseId = $course->id;
        $lesson = $this->lessonRepository->getLessonOfCourse($courseId);

        if (isset($lesson['errorMsg']) || $lesson == null) {
            return redirect()->route('fels.course.detail', $course)
                    ->with('error', trans('messages.front_end.fels.lesson_not_found'));
        }

        return view('front-end.lessons.exam', ['lesson' => $lesson ]);
    }

    // check exam lesson
    public function checkExamLesson(Request $request)
    {
        $data = $request->all();
        $result = $this->lessonRepository->checkResult($data);
        $lesson = $this->lessonRepository->findById($request->lessonId);

        if (isset($result['errorMsg'])) {
            return back()->with('error', trans('messages.front_end.fels.exam_check_error'));
        }

        return redirect()->route('fels.lesson.result', $lesson);
    }

    // get all result of lesson
    public function getResultLessons(Lesson $lesson)
    {
        $lessonId = $lesson->id;
        $lessonName = $lesson->name;
        $results = $this->lessonRepository->getResults($lessonId);
        $totalQuestion = $this->lessonRepository->getTotalQuestion($lessonId);

        if (isset($results['errorMsg']) || isset($totalQuestion['errorMsg'])) {
            return back()->with('error', trans('messages.question.not_found'));
        }

        return view('front-end.lessons.result', [
                    'lessonName' => $lessonName,
                    'results' => $results,
                    'totalQuestion' => $totalQuestion,
                    ]);
    }
}
