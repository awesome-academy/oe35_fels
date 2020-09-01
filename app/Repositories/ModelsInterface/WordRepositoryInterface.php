<?php
namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface WordRepositoryInterface extends RepositoryInterface
{
    public function getAllWord();
    public function checkWordIsLearn();
    public function getCourseList();
    public function filterWord($request);
}