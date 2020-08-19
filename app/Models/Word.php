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
        return $this->belongsToMany(User::class, 'user_word', 'word_id', 'user_id');
    }
}
