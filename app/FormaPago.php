<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;

class FormaPago extends Model
{
  protected $table = "forma_pago";

  public function clientes(){
    return $this->hasMany(Cliente::class);
  }
}
