<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;
use App\Entrada;

class EntradaDetalle extends Model
{
  protected $table = "entrada_detalle";

  public function entrada(){
    return $this->belongsTo(Entrada::class);
  }

  public function producto(){
    return $this->belongsTo(Producto::class);
  }
}
