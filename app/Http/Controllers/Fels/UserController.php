<?php

namespace App\Http\Controllers\Fels;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // get user profile
    public function getProfile(Profile $user)
    {
        return view('front-end.users.profile', ['profile' => $user]);
    }

    // update user info
    public function updateInfo(ProfileRequest $request)
    {
        $user = Auth::user();
        $result = $this->userRepository->updateProfile($user, $request->all());

        if ($result) {
            return redirect()->route('fels.user.profile', $user->profile->name)
                    ->with('success', trans('messages.front_end.profile.update_success'));
        }

        return back()->with('error', trans('messages.front_end.profile.update_error'));
    }

    // update user password
    public function updatePassword(PasswordRequest $request)
    {
        $user = Auth::user();
        $result = $this->userRepository->updatePassword($user, $request->all());

        switch ($result) {
            case true:
                Auth::logout();

                return redirect()->route('login')
                        ->with('success', trans('messages.front_end.profile.update_success'));
                break;

            case false:
                return back()->with('error', trans('messages.front_end.profile.password_error_diff'));
                break;

            case null:
                return back()->with('error', trans('messages.front_end.profile.password_not_match'));
                break;

            default:
                return back()->with('error', trans('messages.front_end.profile.update_error'));
                break;
        }
    }
}
