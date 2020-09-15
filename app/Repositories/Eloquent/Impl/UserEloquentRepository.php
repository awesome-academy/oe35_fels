<?php

namespace App\Repositories\Eloquent\Impl;

use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\ModelsInterface\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

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
                $result = null;
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

    // get relationship with count
    public function getCountRelated($userId, $related)
    {
        try {
            $resultCount = $this->model->whereId($userId)->withCount($related)->first();

            return $resultCount;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get count statistics
    public function getUserCountStatistic($userId, $related)
    {
        try {
            $countStatistic = collect();
            if (is_array($related)) {
                foreach ($related as $value) {
                    $data = $this->getCountRelated($userId, $value);
                    $countName = $value . '_count';
                    if (isset($data['errorMsg'])) {
                        $countStatistic->$countName = config('const.n_a');
                    } else {
                        $countStatistic->$countName = $data->$countName;
                    }
                }
            }

            return $countStatistic;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get total word by month in a year
    public function getTotalWordMonth($userId)
    {
        try {
            $result = DB::table('user_word')
            ->select(
                DB::raw('count(status) as `totalWord`'),
                DB::raw('MONTH(created_at) month')
            )
            ->where(DB::raw('user_id'), '=', $userId)
            ->where(DB::raw('status'), config('const.learned'))
            ->where(DB::raw('YEAR(created_at)'), config('const.year'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

            return $result;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // find or create user login
    public function findOrCreateUser($providerUser, $driver)
    {
        try {
            $providerEmail = $providerUser->getEmail();
            $providerAvatar = $providerUser->getAvatar();
            $providerName = $providerUser->getName();
            $authUser =  $this->model->whereEmail($providerEmail)->first();
            if ($authUser) {
                // update user info
                $profile = $authUser->profile;
                $profile->avatar = $providerAvatar;
                $profile->name = $providerName;
                $authUser->social->access_token = $providerUser->token;

                $authUser->push();
            } else {
                // create a new user
                $authUser = $this->model->create([
                    'role_id' => config('const.seeder.role_id'),
                    'email' => $providerEmail,
                    'email_verified_at' => \Carbon\Carbon::now(),
                    'password' => bcrypt($providerEmail),
                ]);

                // linked user info
                $socialAccount = new \App\Models\Social();
                $socialAccount->provider_id = $providerUser->getId();
                $socialAccount->provider_name = $driver;
                $socialAccount->access_token = $providerUser->token;
                $authUser->social()->save($socialAccount);

                // profile info
                $profile = new \App\Models\Profile();
                $profile->name = $providerName;
                $profile->avatar = $providerAvatar;
                $authUser->profile()->save($profile);
            }

            return $authUser;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get json users
    public function jsonUsers()
    {
        try {
            $data = $this->model::select('*')->withTrashed();

            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    $profile = $data->profile;
                    if ($profile == null) {
                        return null;
                    }

                    return $profile->name;
                })
                ->addIndexColumn()->toJson();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get user
    public function findByIdWithTrashed($id)
    {
        try {
            $user = $this->model->withTrashed()->findOrFail($id);

            return $user;
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // restore user
    public function restoreSoftDelete($user)
    {
        try {
            return $user->restore();
        } catch (\Exception $e) {
            return $this->errroResult($e->getMessage());
        }
    }

    // get users by role
    public function getUserByRole($roleId)
    {
        try {
            $users = $this->model->active()->where('role_id', $roleId)->get();

            return $users;
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }

    // mark all read notification
    public function markAllReadNotify($userId)
    {
        try {
            $user = $this->findById($userId);
            $user->unreadNotifications->markAsRead();

            return true;
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }

    // get courses which user had learned but not finish lesson
    public function getCoursesNotDoLesson($userId)
    {
        try {
            $user = $this->findById($userId);
            /*
            Get courses which user had learned but not do the lesson
            1. Get courses user had learned
            2. Get only courses have lesson
            3. Get only lessons which user not do the lesson
            4. combine condition
            */
            $courses = $user->courses()
                            ->whereHas('lesson', function ($query) {
                                return $query->doesntHave('users');
                            })
                            ->get();

            return $courses;
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }

    // get chart data for admin statistic
    public function getChartDataUser($datetime)
    {
        try {
            switch ($datetime) {
                case 'month':
                    $result = DB::table('users')
                            ->select(
                                DB::raw('count(id) as value,
                                month(created_at) as indexs')
                            )
                            ->where(DB::raw('YEAR(created_at)'), config('const.year'))
                            ->groupBy(DB::raw('month(created_at)'))
                            ->get();

                    return $result;

                    break;
                case 'quarter':
                    $result = DB::table('users')
                            ->select(
                                DB::raw('count(id) as value,
                                quarter(created_at) as indexs')
                            )
                            ->where(DB::raw('YEAR(created_at)'), config('const.year'))
                            ->groupBy(DB::raw('quarter(created_at)'))
                            ->get();

                    return $result;

                    break;
                case 'year':
                    $result = DB::table('users')
                            ->select(
                                DB::raw('count(id) as value,
                                year(created_at) as indexs')
                            )
                            ->groupBy(DB::raw('year(created_at)'))
                            ->get();

                    return $result;

                    break;
            }
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }

    // count total user
    public function countTotalUser()
    {
        try {
            $data = $this->model->withTrashed()->count();

            return $data;
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }

    // count total user
    public function countTotalActiveUser()
    {
        try {
            $data = $this->model->active()->count();

            return $data;
        } catch (\Exception $e) {

            return $this->errroResult($e->getMessage());
        }
    }
}
