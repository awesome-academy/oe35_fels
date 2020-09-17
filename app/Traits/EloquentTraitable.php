<?php

namespace App\Traits;

trait EloquentTraitable
{
    /**
     * Make an empty Collection
    */
    public function makeEmptyCollection()
    {
        return collect([]);
    }

    /**
     * Count total record of table - model
    */
    public function countTotalRecord($modelClass)
    {
        try {
            $model = app()->make($modelClass);
            $data = $model->count();

            return $data;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
