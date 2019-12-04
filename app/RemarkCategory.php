<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemarkCategory extends Model
{
    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }
}
