<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\FormaPago;

class ClienteFormaPago extends Model
{
  protected $table = "cliente_forma_pago";

  public function cliente(){
    return $this->belongsTo(Cliente::class);
  }

  public function formaPago(){
    return $this->belongsTo(FormaPago::class);
  }
}
