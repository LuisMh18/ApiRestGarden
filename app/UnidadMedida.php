<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;

class UnidadMedida extends Model
{
  protected $table = "unidad_medida";

  public function productos(){
    return $this->hasMany(Producto::class);
  }
}
