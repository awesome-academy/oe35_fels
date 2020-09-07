<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'name',
        'mean',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_word', 'word_id', 'user_id')
            ->withPivot('status')->withTimestamps();
    }

    public function rememberWord($userId, $wordId)
    {
        return $this->users()->wherePivot('user_id', $userId)->wherePivot('word_id', $wordId);
    }

    public function scopeCourse($query, $request)
    {
        if ($request->course) {
            $query->where('course_id', $request->course);
        }

        return $query;
    }

    public function scopeLearned($query, $request, $array=[])
    {
        if ($request->orderByLearn === 'is_learned') {
            $query->whereIn('id', $array);
        }

        return $query;
    }

    public function scopeNotDone($query, $request, $array = [])
    {
        if ($request->orderByLearn === 'not_done') {
            $query->whereNotIn('id', $array);
        }

        return $query;
    }

    public function scopeDesc($query, $request)
    {
        if ($request->orderByName === 'desc') {
            $query->orderBy('name', 'DESC');
        }

        return $query;
    }

    public function scopeAsc($query, $request)
    {
        if ($request->orderByName === 'asc') {
            $query->orderBy('name', 'ASC');
        }

        return $query;
    }
}
