<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;

class Alerta extends Model
{
  protected $table = "alertas";

  public function producto(){
    return $this->belongsTo(Producto::class);
  }
}
