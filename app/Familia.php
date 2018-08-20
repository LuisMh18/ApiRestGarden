<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;
use App\Descuento;

class Familia extends Model
{
  protected $table = "familia";

  public function productos(){
    return $this->hasMany(Producto::class);
  }

  public function descuentos(){
    return $this->hasMany(Descuento::class);
  }
}
