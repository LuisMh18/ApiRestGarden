<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Pedido;
use App\DireccionCliente;
use App\TelefonoCliente;
use App\ClienteFormaPago;
use App\NivelDescuento;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $fillable = [
        'rfc',
        'nombre',
        'paterno',
        'materno',
        'password',
        'numero_cliente',
        'nombre_comercial',
        'razon_social',
    ];



    public function direccionClientes(){
  		return $this->hasMany(DireccionCliente::class);
  	}

  	public function telefonoClientes(){
  		return $this->hasMany(TelefonoCliente::class);
  	}

  	public function pedidos(){
  		return $this->hasMany(Pedido::class);
  	}

  	public function clienteFormaPagos(){
  		return $this->hasMany(ClienteFormaPago::class);
  	}

    public function user(){
        return $this->belongsTo(User::class);
    }

  	public function nivelDescuento(){
  		return $this->belongsTo(NivelDescuento::class);
  	}
}
