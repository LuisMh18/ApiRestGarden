<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DireccionCliente;
use App\Cliente;

class TelefonoCliente extends Model
{
  protected $table = "telefono_cliente";

  public function direccionClientes(){
    return $this->hasMany(DireccionCliente::class);
  }

  public function cliente(){
    return $this->belongsTo(Cliente::class);
  }
}
