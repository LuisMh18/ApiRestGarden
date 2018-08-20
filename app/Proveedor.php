<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Entrada;
use App\DireccionProveedor;
use App\TelefonoProveedor;
use App\Contacto;
use App\Comercializador;

class Proveedor extends Model
{
  protected $table = "proveedor";

  public function direccionProveedores(){
    return $this->hasMany(DireccionProveedor::class);
  }

  public function telefonoProveedores(){
    return $this->hasMany(TelefonoProveedor::class);
  }

  public function entradas(){
    return $this->hasMany(Entrada::class);
  }

  public function contactos(){
    return $this->hasMany(Contacto::class);
  }

  public function comercializador(){
    return $this->belongsTo(Comercializador::class);
  }
}
