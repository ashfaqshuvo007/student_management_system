<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  protected $fillable = [
      'login', 'logout', 'teacher_id'
  ];
  public function teacher(){
      return $this->belongsTo(Teacher::class);
    }
}
