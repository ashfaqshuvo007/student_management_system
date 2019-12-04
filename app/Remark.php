<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $fillable = [
        'student_id','sender_id','remark_title','remarks'
    ];
    //Remarks belongs to sigle user/admin
    public function teachers(){
        return $this->belongsTo(Teacher::class,'id');
    }

    //Remarks belongs to sigle user/admin
    public function users(){
        return $this->belongsTo(User::class,'id');
    }


    //Remarks belongs  to Single category
    public function RemarkCategory(){
        return $this->belongsTo(RemarkCategory::class,'id');
    }
}
