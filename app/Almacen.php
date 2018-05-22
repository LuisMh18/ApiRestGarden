<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Producto;

class Almacen extends Model
{
    protected $table = 'almacen';

    public function productos() {
        return $this->hasMany(Producto::class);
    }
}
