<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pedido;

class ExtraPedido extends Model
{
  protected $table = "extra_pedido";

  public function pedido(){
    return $this->belongsTo(Pedido::class);
  }
}
