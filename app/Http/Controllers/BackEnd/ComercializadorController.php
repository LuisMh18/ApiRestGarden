<?php

namespace App\Http\Controllers\BackEnd;

use App\Comercializador;
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

class ComercializadorController extends Controller
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

        $data = DB::table('comercializador');

        $orden = ($request->order != '') ? $request->order : 'desc';
       // $campo = ($request->campo != '0') ? 'almacen.'.$request->campo : 'almacen.id';
        $search = $request->search;

        if($request->has('search')){
            $data->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%'.$search.'%')
                      ->orWhere('comercializador.created_at',  'like', '%'.$search.'%');
            });
        }


        $data = $data->orderBy('id', $orden)
        ->select('id', 'nombre', 'created_at')
        ->get();

        return $this->showAll($data);
    }

    public function data()
    {

        $data = DB::table('comercializador')
                    ->select('id', 'nombre', 'created_at')
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
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|min:3',
          ]);


        if ($validate->fails()) {
            return response()->json([
             'error' => 'validate',
             'errors' => $validate->errors(),
             'code' => 422
            ]);
        }

        $comercializador = new Comercializador;
        $comercializador->nombre = $request->nombre;
        $comercializador->save();

        return response()->json([
            'error' => false,
            'message' => "Comercializador $comercializador->nombre creado exitosamente!",
            'data' => $comercializador,
             201
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comercializador  $comercializador
     * @return \Illuminate\Http\Response
     */
    public function show(Comercializador $comercializador)
    {
        return response()->json(['data' => $comercializador], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comercializador  $comercializador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comercializador $comercializador)
    {

          if($request->has('nombre')){
            $comercializador->nombre = $request->nombre;
          }

           //el metodo isDirty valida si algunos e los valores originales ah cambiado su valor
           if(!$comercializador->isDirty()){
             return response()->json([
                'error' => true,
                'message' => 'Se debe de especificar un valor diferente para actualizar',
                 422
            ]);
           }

           $comercializador->save();

           return response()->json([
            'error' => false,
            'message' => "Comercializador $comercializador->nombre actualizado exitosamente!",
            'data' => $comercializador,
             201
          ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comercializador  $comercializador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comercializador $comercializador)
    {
        $comercializador->delete();
        return response()->json([
            'error' => false,
            'message' => "Comercializador $comercializador->nombre eliminado exitosamente!",
            'data' => $comercializador,
             201
          ]);
    }
}
