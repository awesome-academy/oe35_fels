<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Question;

class Lession extends Model
{
    protected $fillable = [
        'name',
        'score',
        'is_passed',
        'course_id',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'lesson_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
