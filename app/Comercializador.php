<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Proveedor;

class Comercializador extends Model
{
    protected $table = "comercializador";

	public function proveedores(){
		return $this->hasMany(Proveedor::class);
	}
}
