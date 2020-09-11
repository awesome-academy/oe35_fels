<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WordRequest;
use App\Repositories\ModelsInterface\WordRepositoryInterface;
use App\Traits\JsonData;
use Illuminate\Http\Request;

class WordController extends Controller
{
    use JsonData;

    private $wordRepository;

    public function __construct(WordRepositoryInterface $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->wordRepository->jsonWords();
        }

        return view('back-end.words.index');
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
    public function store(WordRequest $request)
    {
        try {
            $result = $this->wordRepository->storeWordJSON($request->all());
            if (isset($result['errorMsg'])) {
                return $this->jsonMsgResult($result, false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.json.success'), 201);
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
            $data = $this->wordRepository->findById($id);
            $word = $this->wordRepository->getCourseName($id);
            $data->course_name = $word['0']->name;

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
            $word = $this->wordRepository->findById($id);
            $result = $this->wordRepository->destroy($word);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result, false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.json.success_delete'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }
}
