<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;

class Contacto extends Model
{
  protected $table = "contacto";

  public function proveedor(){
    return $this->belongsTo(Proveedor::class);
  }
}
