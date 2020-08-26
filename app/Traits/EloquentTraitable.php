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
}
