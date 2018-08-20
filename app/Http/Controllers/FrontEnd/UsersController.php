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
use Hash;
use Auth;
use App\Traits\ApiResponser;

class UsersController extends Controller
{

  use ApiResponser;

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
    public function index(Request $request)
    {

        $nivel = DB::table('cliente')
              ->join('nivel_descuento', 'cliente.nivel_descuento_id', '=', 'nivel_descuento.id')
              ->select('descripcion')
              ->where('cliente.usuario_id', Auth::user()->id)
              ->value('descripcion');

        $data = DB::table('producto')
          ->join('producto_precio', 'producto.id', '=', 'producto_precio.producto_id')
          ->join('inventario', 'producto.id', '=', 'inventario.producto_id')
          ->join('familia', 'producto.familia_id', '=', 'familia.id')
          ->select('producto.id', 'nombre', 'color', 'foto', 'iva0', 'cantidad', 'precio', 'clave', 'tipo')
          ->orderBy('producto.id', 'desc')
          ->where('producto.estatus', 1)
          ->where('producto_precio.estatus', 1);

        if($request->categoria_id !== '0'){
          $data->where('categoria_id', $request->categoria_id);
        }

        switch($nivel)
        {
            case 'Retail':
                $data->where('tipo', 1);
                break;
            case 'Mayorista':
                $data->where('tipo', 2);
                break;
            case 'Distribuidor':
                $data->where('tipo', 3);
                break;
        }

        $data = $data->get();

      return $this->showAll($data);

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
            'usuario' => 'required|unique:usuario|min:6|max:20',
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



        $reglas = [];


        array_push($reglas
        //, "usuario' => 'required|unique:usuario|min:6|max:20"
        //,"password' => 'required|min:6|confirmed"
      // ,"'usuario' => 'required|unique:usuario|min:6|max:20'"
      ,"esto' es una \" prueba '"
);

/*
$validate = Validator::make($request->all(), [
    'usuario' => 'required|unique:usuario|min:6|max:20',
 ]);




 if ($validate->fails()) {
    return response()->json([
     'error' => 'validate',
     'errors' => $validate->errors(),
     'code' => 422
    ]);
}
die;*/

return response()->json($reglas[0]); die;

      /*  $cadena = "esto' es una \" prueba '\r";
        $cadena3 = "'usuario' => 'required|unique:usuario|min:6|max:20'";
       // echo $cadena; //Devolverá --> esto' es una " prueba '
        echo $cadena3; //Devolverá --> esto' es una " prueba '

       // return response()->json($cadena3);

        die;*/

    /*    array_push($reglas
            , "'usuario' => 'required|unique:usuario|min:6|max:20'"
        );


       // 'usuario' => 'required|unique:usuario|min:6|max:20',

       // var_dump($reglas[0]['usuario']); die;

        return response()->json($reglas[0]);*/


         //si en caso de que lo que se busca no exista para esp se usa el metodo findOrFail
         $user = User::findOrFail($id);
          $contador = 0;
          $regla1;
          //mediante el metodo has verificamos que tengamos un campo con el nombre asignado
          if($request->has('usuario')){

            $contador++;
            $regla1 = "'usuario' => 'required|unique:usuario|min:6|max:20'";

            $validate = Validator::make($request->all(), [
                'usuario' => 'required|unique:usuario|min:6|max:20',
             ]);




           /* if ($validate->fails()) {
                return response()->json([
                 'error' => 'validate',
                 'errors' => $validate->errors(),
                 'code' => 422
                ]);
            }*/

            $user->usuario = $request->usuario;
          }


          //comprobamos si el usuario a cambiado su contrasea
          if($request->has('new_password')){
             //en caso de que si comparamos que la contrasea enviada sea la misma a la de la bd
            if (Hash::check($request->password, $user->password)) {

                    //validamos las nuevas contrasea
                    $rule_pass = [
                      'new_password' => 'min:6|confirmed',//la coontrasea debe de ser confirmada con un campo llamado password_confirmation
                      'password' => 'required|min:6|confirmed'
                    ];

                    $contador++;
                    $regla2 = "'new_password' => 'min:6|confirmed'";

                  // $this->validate($request, $rule_pass);

                 /*  if($request->new_password != $request->password_confirmation){
                        return $this->errorResponse('El campo de confirmación de la nueva contraseña no coincide. ', 422);
                   }*/

                   $user->password = bcrypt($request->new_password);

                } else {

                    return response()->json([
                        'error' => true,
                        'message' => 'Tu contraseña actual no coincide',
                         422
                    ]);

                }

          }

           //el metodo isDirty valida si algunos e los valores originales ah cambiado su valor
           if(!$user->isDirty()){
             return response()->json([
                'error' => true,
                'message' => 'Se debe de especificar un valor diferente para actualizar',
                 422
            ]);
           } else {

            if($contador == 1){

                $validate = Validator::make($request->all(), [
                    $regla1,
                 ]);

                if ($validate->fails()) {
                    return response()->json([
                     'error' => 'validate',
                     'errors' => $validate->errors(),
                     'code' => 422
                    ]);
                }

            }

            return response()->json([
                'error' => true,
                'message' => $contador,
                 422
            ]);

           }

           die;
           $user->save();

           return response()->json([
            'error' => false,
            'message' => "Usuario $user->name actualizado exitosamente!",
            'data' => $user,
             200
   ]);
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
