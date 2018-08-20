<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PedidoDetalle;
use App\Cliente;
use App\Loge;
use App\Mensajeria;
use App\DireccionCliente;
use App\ExtraPedido;

class Pedido extends Model
{
  protected $table = "pedido";

  public function pedidoDetalles(){
    return $this->hasMany(PedidoDetalle::class);
  }

  public function loges(){
    return $this->hasMany(Loge::class);
  }

  public function cliente(){
    return $this->belongsTo(Cliente::class);
  }

  public function mensajeria(){
    return $this->belongsTo(Mensajeria::class);
  }

  public function direccionCliente(){
    return $this->belongsTo(DireccionCliente::class);
  }

  public function extraPedidos(){
    return $this->hasMany(ExtraPedido::class);
  }
}
