<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Social;
use App\Models\Role;
use App\Models\Profile;
use App\Models\Course;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function social()
    {
        return $this->hasOne(Social::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')->withTimestamps();
    }

    public function words()
    {
        return $this->belongsToMany(Word::class, 'user_word', 'user_id', 'word_id')
                    ->withPivot('status')->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user', 'user_id', 'lesson_id')
                    ->withPivot('score')->withTimestamps();
    }
}
