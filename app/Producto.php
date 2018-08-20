<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EntradaDetalle;
use App\ProductoPrecio;
use App\Familia;
use App\Categoria;
use App\Inventario;
use App\Alerta;
use App\PedidoDetalle;
use App\Importador;
use App\Almacen;
use App\UnidadMedida;
use App\Movimiento;

class Producto extends Model
{
    protected $table = "producto";

    public function detalles(){
  		return $this->hasMany(EntradaDetalle::class);
  	}

    public function productoPrecios(){
  		return $this->hasMany(ProductoPrecio::class);
  	}

    public function inventarios(){
  		return $this->hasMany(Inventario::class);
  	}

    public function alertas(){
  		return $this->hasMany(Alerta::class);
  	}

    public function pedidoDetalles(){
  		return $this->hasMany(PedidoDetalle::class);
  	}

    public function familia(){
  		return $this->belongsTo(Familia::class);
  	}

    public function categoria(){
  		return $this->belongsTo(Categoria::class);
  	}

    public function importador(){
  		return $this->belongsTo(Importador::class);
  	}

    public function almacen(){
  		return $this->belongsTo(Almacen::class);
  	}

    public function unidadMedida(){
  		return $this->belongsTo(UnidadMedida::class);
  	}

    public function movimientos(){
  		return $this->hasMany(Movimiento::class);
  	}
}
