<?php

namespace App\Http\Controllers\BackEnd;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use AppHttpRequests;
use AppHttpControllersController;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Validator;
use DB;
use App\Traits\ApiResponser;
use Auth;

class UsuariosController extends Controller
{
    use ApiResponser;

    public function __construct(){
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = DB::table('usuario')
                ->leftJoin('usuario_detalle',  'usuario.id', '=', 'usuario_detalle.usuario_id')
                ->join('rol',  'usuario.rol_id', '=', 'rol.id');

        $orden = ($request->order != '') ? $request->order : 'desc';
       // $campo = ($request->campo != '0') ? 'almacen.'.$request->campo : 'almacen.id';
        $search = $request->search;

        if($request->has('search')){
            $data->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%'.$search.'%')
                      ->orWhere('paterno',  'like', '%'.$search.'%')
                      ->orWhere('materno',  'like', '%'.$search.'%')
                      ->orWhere('usuario',  'like', '%'.$search.'%')
                      ->orWhere('email',  'like', '%'.$search.'%')
                      ->orWhere('usuario.created_at',  'like', '%'.$search.'%');
            });
        }


        if($request->rol != 0){
            $data->where('usuario.rol_id',  $request->rol);
        }

        if($request->export != ''){
            $data->select('usuario.id', DB::raw('CONCAT(usuario_detalle.nombre," ",usuario_detalle.paterno," ",usuario_detalle.materno) as nombre_completo'), 'usuario', 'email', 'rol.nombre as rol', 'usuario.created_at');
        } else {
            $data->select('usuario.id', DB::raw('CONCAT(usuario_detalle.nombre," ",usuario_detalle.paterno," ",usuario_detalle.materno) as nombre_completo'), 'usuario', 'email', 'imagen', 'rol_id', 'rol.nombre as rol', 'usuario.created_at');
        }

        $data = $data->orderBy('usuario.id', $orden)
        ->where('usuario.rol_id',  '!=', 1)
        ->get();

        return $this->showAll($data);
    }


    public function roles(){
        $data = DB::table('rol')
                    ->where('nombre',  '!=', 'Cliente')
                    ->orderBy('id', 'desc')
                    ->get();

        return response()->json([
            'error' => false,
            'data' => $data,
             201
       ]);
    }


    public function data()
    {

        $data = DB::table('usuario')
                    ->leftJoin('usuario_detalle',  'usuario.id', '=', 'usuario_detalle.usuario_id')
                    ->join('rol',  'usuario.rol_id', '=', 'rol.id')
                    ->where('usuario.rol_id',  '!=', 1)
                    ->select('usuario.id', DB::raw('CONCAT(usuario_detalle.nombre," ",usuario_detalle.paterno," ",usuario_detalle.materno) as nombre_completo'), 'usuario', 'email', 'rol.nombre as rol', 'usuario.created_at')
                    ->orderBy('id', 'desc')
                    ->get();



        return response()->json([
            'error' => false,
            'data' => $data,
             201
       ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        

        $data = DB::table('usuario')
                    ->leftJoin('usuario_detalle',  'usuario.id', '=', 'usuario_detalle.usuario_id')
                    ->join('rol',  'usuario.rol_id', '=', 'rol.id')
                    ->where('usuario.rol_id',  '!=', 1)
                    ->select('usuario.id', 'usuario_detalle.nombre', 'usuario_detalle.paterno', 'usuario_detalle.materno' , 'usuario', 'email', 'rol_id', 'imagen')
                    ->where('usuario.id', $usuario->id)
                    ->first();


      return response()->json(['data' => $data], 201);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
