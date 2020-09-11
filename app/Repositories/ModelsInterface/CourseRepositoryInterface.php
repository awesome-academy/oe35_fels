<?php

namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface CourseRepositoryInterface extends RepositoryInterface
{
    // get course records
    public function jsonCourses();

    // store record
    public function storeCourseJSON($request);


    // get course list for lesson
    public function getCourseList();

    // e-learning - get all courses
    public function getAllCourses();

    // e-learning - get top courses
    public function getPopularCourses();

    // e-learning - get course detail and words
    public function getWordsAndStatusByCourse($userId, $courseId);

    // e-learning - user learn course
    public function learnCourse($userId, $courseId);

    // user remember word
    public function learnWord($userId, $wordId);
}
