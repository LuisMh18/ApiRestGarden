<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use AppHttpRequests;
use AppHttpControllersController;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Usuario;
use Auth;
use Validator;
use DB;

class AuthenticateController extends Controller{

  public function __construct(){
      // Aplicar el middleware jwt.auth a todos los métodos de este controlador
      // excepto el método authenticate. No queremos evitar
      // el usuario de recuperar su token si no lo tiene ya
      $this->middleware('jwt.auth', ['except' => ['login']]);

       //Route::group(['middleware' => 'authenticated'], function () {
   }


   public function login(Request $request)
   { 
       $validate = Validator::make($request->all(), [
           'email' => 'required|email',
           'password' => 'required',
       ]);


       if ($validate->fails()) {
           return response()->json([
            'error' => 'validate',
            'errors' => $validate->errors(),
            'code' => 422
           ]);
       }

       $credentials = $request->only('email', 'password');

       try {
           // verifique las credenciales y cree un token para el usuario
             if (!$token = JWTAuth::attempt($credentials)) {
                 /*-- Nota:
                  * Error 401 - no autorizado: -> indica que se denegó el acceso a causa de las credenciales no válidas.*/
                 return response()->json([
                          'error' => true,
                          'message' => 'El email o la contraseña son incorrectos',
                           401
                 ]);
             }
       } catch (JWTException $e) {
           // something went wrong whilst attempting to encode the token
           return response()->json([
                          'error' => true,
                          'message' => 'No se pudo crear token, intentelo otravez.',
                           500
                 ]);
       }

      

       $user = DB::table('usuario');
       if(Auth::user()->rol_id === 1){
            $user->join('cliente', 'usuario.id', '=', 'cliente.usuario_id')
            ->select('usuario.id', 'email', 'usuario', 'rol_id', 'nombre_cliente', 'paterno', 'materno');
       } else {
            $user->join('usuario_detalle', 'usuario.id', '=', 'usuario_detalle.usuario_id')
            ->select('usuario.id', 'email', 'usuario', 'rol_id', 'nombre', 'paterno', 'materno', 'imagen');      
       }

            $user = $user->where('usuario.id', Auth::user()->id)
            ->first();


       return response()->json([ 'token' => $token, 'data' => $user ], 200);
   }


   public function logout(Request $request) {

        $validate = Validator::make($request->all(), [
           'token' => 'required',
        ]);


       if ($validate->fails()) {
           return response()->json([
            'error' => 'validate',
            'errors' => $validate->errors(),
            'code' => 422
           ]);
       }


        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json([
                           'error' => false,
                           'message' => 'Tu sesión ha sido serrada correctamente.',
                            200
                  ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                           'error' => true,
                           'message' => 'Error al cerrar la sesión, intente de nuevo.',
                            500
                  ]);
        }
    }




}
