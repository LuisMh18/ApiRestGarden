<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Cliente;
use App\UsuarioDetalle;
use App\Loge;
use App\Rol;
use App\Movimiento;
//use App\Reservation;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'usuario';
   // public $timestamps = false;


   //atributos que pueden ser asignados de manera masiva, una asignasion masiva de manera masiva en laravel cuando se realiza
    //el establecimiento de tal atributo por medio del metodo create o update
    protected $fillable = [
        'rol_id',
        'usuario',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     //atributos ocultos
     protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];


    public function clientes() {
        return $this->hasMany(Cliente::class);
    }

    public function usuarioDetalles(){
  		return $this->hasMany(UsuarioDetalle::class);
  	}

  	public function loges(){
  		return $this->hasMany(Loge::class);
  	}

  	public function rol(){
  		return $this->belongsTo(Rol::class);
  	}

    public function movimientos(){
  		return $this->hasMany(Movimiento::class);
  	}



}
