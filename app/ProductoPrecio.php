<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PedidoDetalle;
use App\Producto;

class ProductoPrecio extends Model
{
    protected $table = "producto_precio";

    public function pedidoDetalles(){
  		return $this->hasMany(PedidoDetalle::class);
  	}

  	public function producto(){
  		return $this->belongsTo(Producto::class);
  	}
}
