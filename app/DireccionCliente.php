<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pedido;
use App\Cliente;
use App\TelefonoCliente;
use App\Pais;
use App\Estado;
use App\Municipio;

class DireccionCliente extends Model
{
  protected $table = "direccion_cliente";

  public function pedidos(){
    return $this->hasMany(Pedido::class);
  }

  public function cliente(){
    return $this->belongsTo(Cliente::class);
  }

  public function telefonoCliente(){
    return $this->belongsTo(TelefonoCliente::class);
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
