<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Question;

class Lesson extends Model
{
    protected $fillable = [
        'name',
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_user', 'lesson_id', 'user_id')
                    ->withPivot('score')->withTimestamps();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
