<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use AppHttpRequests;
use AppHttpControllersController;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Usuario;
use App\Reservation;
use Auth;
use Validator;
use DB;
use App\Traits\ApiResponser;

class AuthenticateController extends Controller{

  use ApiResponser;

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

       return response()->json([ 'token' => $token ], 200);
   }


   public function getUser()
    {
        $data = Auth::user(); //usuario que inicio sesion

        return response()->json(['data' => $data]);
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
