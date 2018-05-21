<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use AppHttpRequests;
use AppHttpControllersController;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\User;
use App\Cliente;
use Validator;
use DB;

class UsersController extends Controller
{

    public function __construct(){
        // Aplicar el middleware jwt.auth a todos los métodos de este controlador
        // excepto el método authenticate. No queremos evitar
        // el usuario de recuperar su token si no lo tiene ya
        $this->middleware('jwt.auth', ['except' => ['store']]);
  
         //Route::group(['middleware' => 'authenticated'], function () {
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'rfc' => 'required|min:13|max:13',
            'nombre' => 'required|min:3|max:30',
            'paterno' => 'required|min:3',
            'usuario' => 'required|unique:usuario',
            'email' => 'required|unique:usuario',//el email debe de ser unico en la tabla usuario
            'password' => 'required|min:6|confirmed'
        ]);
 
 
        if ($validate->fails()) {
            return response()->json([
             'error' => 'validate',
             'errors' => $validate->errors(),
             'code' => 422
            ]);
        }

        /* Rol de usuarios
         * 1 - Cliente
         * 2 - Agente
         * 3 - Administrador
        */

        $user = new User;
        $user->rol_id = 1;
        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->remember_token = "";
        $user->save();

        //insertamos en la tabla clientes
        $cliente = new Cliente;
        $cliente->rfc = $request->rfc;
        $cliente->usuario_id = $user->id;
        $cliente->agente_id = 0;
        $cliente->nivel_descuento_id = "1";
        $cliente->nombre_cliente = $request->nombre;
        $cliente->paterno = $request->paterno;
        $cliente->materno = ($request->materno == "") ? "" : $request->materno;
        $cliente->nombre_comercial = ($request->nombre_comercial == "") ? "" : $request->nombre_comercial;
        $cliente->razon_social = ($request->razon_social == "") ? "" : $request->razon_social;
        $cliente->numero_cliente = date('Y').date('m').date("d").date('G').date('i').date('s').$user->id;
        $cliente->save(); 


        return response()->json(['data' => $user], 201);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
