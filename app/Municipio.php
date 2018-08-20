<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DireccionCliente;
use App\Estado;

class Municipio extends Model
{
  protected $table = "municipio";

  public function direcciones(){
    return $this->hasMany(DireccionCliente::class);
  }

  public function estado(){
    return $this->belongsTo(Estado::class);
  }
}
