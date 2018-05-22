<?php

namespace App\Http\Controllers\BackEnd;

use App\Almacen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use AppHttpRequests;
use AppHttpControllersController;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Validator;
use DB;
use App\Traits\ApiResponser;

class AlmacenController extends Controller
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

        //return $this->miMetodo();

        $data = DB::table('almacen');

        $orden = ($request->order != '0') ? $request->order : 'desc';
       // $campo = ($request->campo != '0') ? 'almacen.'.$request->campo : 'almacen.id';
        $search = $request->search;

        if($request->has('search')){
            $data->where(function ($query) use ($search) {
                $query->where('clave', 'like', '%'.$search.'%')
                      ->orWhere('nombre',  'like', '%'.$search.'%')
                      ->orWhere('almacen.created_at',  'like', '%'.$search.'%');
            });
        }

        if($request->estatus != 'todos'){
            $data->where('estatus',  $request->estatus);
        }

                      
        $data = $data->orderBy('id', $orden)
        ->get();

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
            'clave' => 'required|min:3',
            'nombre' => 'required|min:3',
          ]);
 
 
        if ($validate->fails()) {
            return response()->json([
             'error' => 'validate',
             'errors' => $validate->errors(),
             'code' => 422
            ]);
        }
        
        $almacen = new Almacen;
        $almacen->clave = $request->clave;
        $almacen->nombre = $request->nombre;
        $almacen->estatus = ($request->estatus != '' and $request->estatus >= 0 and $request->estatus < 2) ? $request->estatus : 0;
        $almacen->save();

        return response()->json(['data' => $almacen], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        //$almacen = User::find($id);

      //si en caso de que lo que se busca no exista para esp se usa el metodo findOrFail
      //$almacen = User::findOrFail($id);
      return response()->json(['data' => $almacen], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $almacen)
    {
    
          //mediante el metodo has verificamos que tengamos un campo con el nombre asignado, en este caso es
          //el campo name, y si este viene entonces lo actualizamos
          if($request->has('clave')){
            $almacen->clave = $request->clave;
          }

          if($request->has('nombre')){
            $almacen->nombre = $request->nombre;
          }

          if($request->has('estatus')){
            $almacen->estatus = ($request->estatus != '' and $request->estatus >= 0 and $request->estatus < 2) ? $request->estatus : 0;
          }
    
           //el metodo isDirty valida si algunos e los valores originales ah cambiado su valor
           if(!$almacen->isDirty()){
             return response()->json([
                'error' => true,
                'message' => 'Se debe de especificar un valor diferente para actualizar',
                 422
            ]);
           }
    
           $almacen->save();
    
           return response()->json(['data' => $almacen], 201);
    
        }
    

    public function destroy(Almacen $almacen)
    {
        $almacen->delete();
        return response()->json(['data' => $almacen], 201);
    }
}
