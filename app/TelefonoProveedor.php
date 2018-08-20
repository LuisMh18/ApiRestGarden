<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;

class TelefonoProveedor extends Model
{
  protected $table = "telefono_proveedor";

  public function proveedor(){
    return $this->belongsTo(Proveedor::class);
  }
}
