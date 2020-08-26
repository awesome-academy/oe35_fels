<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'name',
        'mean',
        'is_learned',
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
}
