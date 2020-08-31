<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        $model = User::class;
        return $model;
    }

    // update user profile
    public function updateProfile($user, $request)
    {
        try {
            $profile = $user->profile;
            if (isset($request['avatar'])) {
                $imageName = $this->processImage($profile, $request['avatar']);
            } else {
                $imageName = config('const.default_avatar');
            }
            if (isset($request['email'])) {
                $user->email = $request['email'];
            }
            if (isset($request['name'])) {
                $profile->name = $request['name'];
            }
            if (isset($request['gender'])) {
                $profile->gender = $request['gender'];
            }
            $profile->avatar = $imageName;
            $user->push();

            return true;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // update user password
    public function updatePassword($user, $request)
    {
        try {
            $result = true;
            $hashedPassword = $user->password;
            if (Hash::check($request['old_password'], $hashedPassword)) {
                if (!Hash::check($request['password'], $hashedPassword)) {
                    $user->password = bcrypt($request['password']);
                    $user->update([
                        'password' => $user->password,
                    ]);
                } else {
                    $result = false;
                }
            } else {
                $result= null;
            }

            return $result;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // process image update
    public function processImage($profile, $image)
    {
        try {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = config('const.profile_path');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true);
            }

            // Delete old image form profile folder
            $oldImage = $profile->avatar;
            if ($oldImage != config('const.default_avatar')) {
                $oldPath = $path . $oldImage;
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $image->move($path, $imageName);

            return $imageName;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }
}
