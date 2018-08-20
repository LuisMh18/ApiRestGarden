<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EntradaDetalle;
use App\Proveedor;

class Entrada extends Model
{
  protected $table = "entrada";

  public function detalles(){
    return $this->hasMany(EntradaDetalle::class);
  }

  public function proveedor(){
    return $this->belongsTo(Proveedor::class);
  }
}
