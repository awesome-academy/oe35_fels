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
}
