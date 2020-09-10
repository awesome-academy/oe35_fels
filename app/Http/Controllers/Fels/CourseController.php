<?php

namespace App\Http\Controllers\Fels;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Repositories\ModelsInterface\CourseRepositoryInterface;
use App\Repositories\ModelsInterface\LessonRepositoryInterface;
use App\Traits\EloquentTraitable;
use App\Traits\JsonData;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use JsonData, EloquentTraitable;

    private $courseRepository;
    private $lessonRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        LessonRepositoryInterface $lessonRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->lessonRepository = $lessonRepository;
    }

    // get course lists - pagination
    public function getAllCourses()
    {
        $courses = $this->courseRepository->getAllCourses();
        if (isset($courses['errorMsg'])) {
            $courses = $this->makeEmptyCollection();
        }

        return view('front-end.courses.list', ['courses' => $courses]);
    }

    // get popular course for homepage cover
    public function getPopularCourses()
    {
        $popularCourses = $this->courseRepository->getPopularCourses();
        if (isset($popularCourses['errorMsg'])) {
            $popularCourses = $this->makeEmptyCollection();
        }

        return view('front-end.homepage', ['popularCourses' => $popularCourses]);
    }

    // get course detail include words
    public function getCourseInfo(Course $course)
    {
        try {
            $userId = Auth::user()->id;
            $courseId = $course->id;
            $this->courseRepository->learnCourse($userId, $courseId);
            // get all words belong to this course
            $words = $this->courseRepository->getWordsAndStatusByCourse($userId, $courseId);
            if (isset($words['errorMsg'])) {
                $words = collect(); // make empty collection
            }
            // get related lesson by course
            $lesson = $this->lessonRepository->getLessonAndStatusByCourse($courseId);

            return view('front-end.courses.detail', [
                    'course' => $course,
                    'words' => $words,
                    'highestScore' => $lesson->highestScore,
                    'totalQuestion' => $lesson->totalQuestion,
                    'lesson' => $lesson,
                ]);
        } catch (\Exception $e) {
            return view('view', ['test' => $e->getMessage()]);
            return redirect()->route('fels.course.list')
                ->with('error', trans('messages.front_end.fels.course_not_found'));
        }
    }

    // remember word user had learned
    public function rememberWord($wordId)
    {
        try {
            $userId = Auth::user()->id;
            $result = $this->courseRepository->learnWord($userId, $wordId);
            if (isset($result['errorMsg'])) {
                return $this->jsonMsgResult(trans('messages.front_end.fels.no_data'), false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.json.success'), 201);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }
}
