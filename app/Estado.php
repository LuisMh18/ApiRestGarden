<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DireccionCliente;
use App\Pais;
use App\Municipio;

class Estado extends Model
{
  protected $table = "estado";

  public function direcciones(){
    return $this->hasMany(DireccionCliente::class);
  }

  public function pais(){
    return $this->belongsTo(Pais::class);
  }

  public function municipios(){
    return $this->hasMany(Municipio::class);
  }


}
