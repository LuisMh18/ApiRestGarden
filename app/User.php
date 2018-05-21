<?php

namespace App;

use App\Cliente;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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



}




