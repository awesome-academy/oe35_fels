<?php
namespace App\Repositories\ModelsInterface;

use App\Repositories\RepositoryInterface;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    public function getListQuestions();
    public function getAllLesson();
    public function createQuestionAndOptions($request);
    public function getQuestionById($id);
    public function updateQuestionAndOptions($request, $id);
    public function deleteQuestion($id);
}