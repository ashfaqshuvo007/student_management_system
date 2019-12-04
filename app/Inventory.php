<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
  protected $guarded = array(
        // Any columns you don't want to be mass-assignable.
        // Or just empty array if all is mass-assignable.
    );
}
