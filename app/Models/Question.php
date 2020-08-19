<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\Option;

class Question extends Model
{
    protected $fillable = [
        'name',
        'lesson_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }
}
