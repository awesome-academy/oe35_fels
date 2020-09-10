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
}
