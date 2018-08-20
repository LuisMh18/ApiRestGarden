<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;
use App\Pedido;

class Loge extends Model
{
  protected $table = "log";

  public function usuario(){
    return $this->belongsTo(Usuario::class);
  }

  public function pedido(){
    return $this->belongsTo(Pedido::class);
  }
}
