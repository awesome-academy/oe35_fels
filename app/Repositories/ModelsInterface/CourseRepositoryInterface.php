<?php

namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface CourseRepositoryInterface extends RepositoryInterface
{
    // get course records
    public function jsonCourses();

    // store record
    public function storeCourseJSON($request);
}
