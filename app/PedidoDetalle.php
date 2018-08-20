<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pedido;
use App\Producto;
use App\ProductoPrecio;

class PedidoDetalle extends Model
{
    protected $table = "pedido_detalle";

    public function pedido(){
  		return $this->belongsTo(Pedido::class);
  	}

  	public function producto(){
  		return $this->belongsTo(Producto::class);
  	}

  	public function precioProducto(){
  		return $this->belongsTo(ProductoPrecio::class);
  	}
}
