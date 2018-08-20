<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pedido;

class Mensajeria extends Model
{
  protected $table = "mensajeria";

  public function pedido(){
    return $this->hasOne(Pedido::class);
  }
}
