<?php

namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    // update user profile
    public function updateProfile($user, $request);

    // update user password
    public function updatePassword($user, $request);

    // process image update
    public function processImage($profile, $image);

    // get count statistics
    public function getUserCountStatistic($userId, $related);

    // get relationship with count
    public function getCountRelated($userId, $related);

    // get total word by month in a year
    public function getTotalWordMonth($userId);

    // find or create user login
    public function findOrCreateUser($user, $driver);

    // get json users
    public function jsonUsers();

    // get user
    public function findByIdWithTrashed($id);

    // restore user
    public function restoreSoftDelete($user);

    // get users by role
    public function getUserByRole($roleId);

    // mark all read notification
    public function markAllReadNotify($userId);

    // get courses which user had learned but not finish lesson
    public function getCoursesNotDoLesson($userId);

    // get chart data for admin statistic by month, quarter, year
    public function getChartDataUser($datetime);

    // count total user
    public function countTotalUser();

    // count total user
    public function countTotalActiveUser();
}
