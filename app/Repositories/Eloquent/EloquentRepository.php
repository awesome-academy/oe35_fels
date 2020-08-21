<?php

namespace App\Repositories\Eloquent;

use App\Repositories\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get Model
     * @return string
     */
    abstract public function getModel();

    /**
     * set Model
     */

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll()
    {
        try {
            return $this->model->all();
        } catch (\Exception $exception) {
            return $this->errroResult($exception->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $exception) {
            return $this->errroResult($exception->getMessage());
        }
    }

    public function create($request)
    {
        try {
            return $this->model->create($request);
        } catch (\Exception $exception) {
            return $this->errroResult($exception->getMessage());
        }
    }

    public function update($request, $object)
    {
        try {
            return $object->update($request);
        } catch (\Exception $exception) {
            return $this->errroResult($exception->getMessage());
        }
    }

    public function destroy($object)
    {
        try {
            return $object->delete();
        } catch (\Exception $exception) {
            return $this->errroResult($exception->getMessage());
        }
    }

    private function errroResult($msg)
    {
        $message = [
            'errorMsg' => $msg
        ];

        return $message;
    }
}
