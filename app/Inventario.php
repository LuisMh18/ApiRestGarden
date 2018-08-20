<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;

class Inventario extends Model
{
  protected $table = "inventario";

  public function producto(){
    return $this->belongsTo(Producto::class);
  }
}
