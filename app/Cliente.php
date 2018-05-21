<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

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

    public function user(){

        return $this->belongsTo(User::class);
        
    }
}
