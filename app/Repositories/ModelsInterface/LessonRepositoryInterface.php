<?php

namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface LessonRepositoryInterface extends RepositoryInterface
{
    // get lesson records
    public function jsonLessons();

    // store record
    public function storeLessonJSON($request);
}
