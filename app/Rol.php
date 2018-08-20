<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Rol extends Model
{
  protected $table = "rol";

  public function usuarios(){
    return $this->hasMany(User::class);
  }
}
