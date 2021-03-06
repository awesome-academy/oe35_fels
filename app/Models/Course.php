<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Word;
use App\Models\Lesson;
use App\Models\User;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function words()
    {
        return $this->hasMany(Word::class, 'course_id', 'id');
    }

    public function lesson()
    {
        return $this->hasOne(Lesson::class, 'course_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    // Get course info with count total related users and words
    public function scopeCountInfo($query)
    {
        return $query->withCount('users')->withCount('words');
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
