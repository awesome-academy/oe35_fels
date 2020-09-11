<?php
namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface WordRepositoryInterface extends RepositoryInterface
{
    public function getAllWord();

    public function checkWordIsLearn();

    public function getCourseList();

    public function filterWord($request);

    // get word records
    public function jsonWords();

    // store record
    public function storeWordJSON($request);

    // get course name
    public function getCourseName($wordId);
}
