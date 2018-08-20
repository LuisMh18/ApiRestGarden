<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Producto;

class Importador extends Model
{
  protected $table = "importador";

  public function productos(){
    return $this->hasMany(Producto::class);
  }
}
