<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Teacher as Authenticatable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teacher';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'gender', 'salary', 'phoneNumber', 'address', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function teacherHassubject(){
        return $this->hasMany(teacherHasSubject::class,'id'); 
    }

    public function teacherHasSection(){
        return $this->hasMany(teacherHasSection::class,'id'); 
    }
}
