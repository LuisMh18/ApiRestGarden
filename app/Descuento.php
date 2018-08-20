<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Familia;
class Descuento extends Model
{
  protected $table = "descuento";

  public function familia(){
    return $this->belongsTo(Familia::class);
  }
}
