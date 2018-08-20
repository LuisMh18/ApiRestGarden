<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;
use App\Pais;
use App\Estado;
use App\Municipio;

class DireccionProveedor extends Model
{
  protected $table = "direccion_proveedor";

  public function proveedor(){
    return $this->belongsTo(Proveedor::class);
  }

  public function pais(){
    return $this->belongsTo(Pais::class);
  }

  public function estado(){
    return $this->belongsTo(Estado::class);
  }

  public function municipio(){
    return $this->belongsTo(Municipio::class);
  }
}
