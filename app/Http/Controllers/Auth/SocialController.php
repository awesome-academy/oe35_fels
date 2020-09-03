<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse(
                trans('messages.social.not_support_driver', ['driver' => $driver])
            );
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        $authUser = $this->userRepository->findOrCreateUser($user, $driver);
        Auth::login($authUser, true);
        return redirect()->intended('/');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->with('error', $msg ?: trans('messages.social.unknown_error'));
        ;
    }

    protected function isProviderAllowed($driver)
    {
        return in_array($driver, config('const.provider')) && config()->has("services.{$driver}");
    }
}
