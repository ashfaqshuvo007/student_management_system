<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Student extends Model
{
  use Sortable; 
  protected $fillable = [
      'name', 'fatherName', 'motherName', 'DOB', 'gender' , 'address', 'contact' ,'bloodGroup', 'birthCertificate','rollNumber','familyIncome', 'father_occupation', 'mother_occupation', 'height', 'weight', 'no_of_siblings'
  ];
  public $sortable = ['name'];
}
