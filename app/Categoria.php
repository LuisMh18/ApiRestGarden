<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Producto;

class Categoria extends Model
{
    protected $table = 'categoria';

    public function productos() {
        return $this->hasMany(Producto::class);
    }
}
