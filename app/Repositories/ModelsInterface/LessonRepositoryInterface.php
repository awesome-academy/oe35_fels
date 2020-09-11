<?php

namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface LessonRepositoryInterface extends RepositoryInterface
{
    // get lesson records
    public function jsonLessons();

    // store record
    public function storeLessonJSON($request);

    // e-learning - get exam lesson of course
    public function getLessonOfCourse($courseId);

    // e-learning - get exam lesson and status of course
    public function getLessonAndStatusByCourse($courseId);

    // e-learning - get exam lesson of course
    public function checkResult($request);

    // e-learning - get highest score of lesson
    public function getHighestScore($lessonId);

    // e-learning - get total question of lesson
    public function getTotalQuestion($lessonId);

    // e-learning - get all results of lesson
    public function getResults($lessonId);
}
