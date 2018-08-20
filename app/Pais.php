<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DireccionCliente;
use App\Estado;

class Pais extends Model
{
  protected $table = "pais";

  public function direcciones(){
    return $this->hasMany(DireccionCliente::class);
  }

  public function estados(){
    return $this->hasMany(Estado::class);
  }
}
