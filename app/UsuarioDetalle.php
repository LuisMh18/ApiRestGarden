<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UsuarioDetalle extends Model
{
  protected $table = "usuario_detalle";

  public function usuario(){
    return $this->belongsTo(User::class);
  }
}
