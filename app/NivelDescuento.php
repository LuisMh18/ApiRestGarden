<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;

class NivelDescuento extends Model
{
  protected $table = "nivel_descuento";

  public function clientes(){
    return $this->hasMany(Cliente::class);
  }
}
