<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;
use App\User;

class Movimiento extends Model
{
  protected $table = "movimientos";

  public function producto(){
    return $this->belongsTo(Producto::class);
  }

  public function usuario(){
    return $this->belongsTo(User::class);
  }
}
