<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Repositories\ModelsInterface\CourseRepositoryInterface;
use App\Traits\JsonData;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use JsonData;

    private $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->courseRepository->jsonCourses();
        }

        return view('back-end.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            $result = $this->courseRepository->storeCourseJSON($request->all());
            if (isset($result['errorMsg'])) {
                return $this->jsonMsgResult($result, false, 500);
            }

            return response()->json([
                'course_id' => $result->id,
                'success' => trans('messages.json.success'),
            ], 201);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = $this->courseRepository->findById($id);
            return $this->jsonDataResult($data, 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $course = $this->courseRepository->findById($id);
            $result = $this->courseRepository->destroy($course);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result, false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.json.success_delete'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    // get course list
    public function getCourseList()
    {
        try {
            $data = $this->courseRepository->getCourseList();

            return $this->jsonDataResult($data, 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Display exception errors of request.
    */
    private function jsonMsgResult($errors, $success, $statusCode)
    {
        $result = [
            'errors' => $errors,
            'success' => $success,
            'statusCode' => $statusCode,
        ];

        return response()->json($result, $result['statusCode']);
    }
}
