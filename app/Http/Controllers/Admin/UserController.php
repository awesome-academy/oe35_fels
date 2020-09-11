<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use App\Traits\JsonData;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonData;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userRepository->jsonUsers();
        }

        return view('back-end.users.index');
    }

    // delete a user using Soft Delete
    public function deleteUser($id)
    {
        try {
            $user = $this->userRepository->findById($id);
            $result = $this->userRepository->destroy($user);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result, false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.json.success_delete'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    // restore a user
    public function restoreUser($id)
    {
        try {
            $user = $this->userRepository->findByIdWithTrashed($id);
            $result = $this->userRepository->restoreSoftDelete($user);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result, false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.json.success_restore'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }
}
