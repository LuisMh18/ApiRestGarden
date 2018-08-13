<?php

namespace App\Http\Controllers\BackEnd;

use App\Categoria;
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

class CategoriasController extends Controller
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

      $data = DB::table('categoria');

      $orden = ($request->order != '') ? $request->order : 'desc';
     // $campo = ($request->campo != '0') ? 'almacen.'.$request->campo : 'almacen.id';
      $search = $request->search;

      if($request->has('search')){
          $data->where(function ($query) use ($search) {
              $query->where('categoria', 'like', '%'.$search.'%')
                    ->orWhere('categoria.created_at',  'like', '%'.$search.'%');
          });
      }

      if($request->estatus != 2){
          $data->where('estatus',  $request->estatus);
      }


      $data = $data->orderBy('id', $orden)
      ->select('id', 'categoria','estatus', 'created_at')
      ->get();

      return $this->showAll($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function data()
     {

         $data = DB::table('categoria')
                     ->select('id', 'categoria', 'estatus', 'created_at')
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
             'categoria' => 'required|min:3',
         ]);


           if ($validate->fails()) {
               return response()->json([
                'error' => 'validate',
                'errors' => $validate->errors(),
                'code' => 422
               ]);
           }

           $categoria = new Categoria;
           $categoria->categoria = $request->categoria;
           $categoria->estatus = ($request->estatus != '' and $request->estatus >= 0 and $request->estatus < 2) ? $request->estatus : 0;
           $categoria->save();

           return response()->json([
               'error' => false,
               'message' => "Categoría $categoria->categoria creada exitosamente!",
               'data' => $categoria,
                201
          ]);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        return response()->json(['data' => $categoria], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
      //mediante el metodo has verificamos que tengamos un campo con el nombre asignado, en este caso es
      //el campo name, y si este viene entonces lo actualizamos
      if($request->has('categoria')){
        $categoria->categoria = $request->categoria;
      }

      if($request->has('estatus')){
        $categoria->estatus = ($request->estatus != '' and $request->estatus >= 0 and $request->estatus < 2) ? $request->estatus : 0;
      }

       //el metodo isDirty valida si algunos e los valores originales ah cambiado su valor
       if(!$categoria->isDirty()){
         return response()->json([
            'error' => true,
            'message' => 'Se debe de especificar un valor diferente para actualizar',
             422
        ]);
       }

       $categoria->save();

       return response()->json([
        'error' => false,
        'message' => "Categoría $categoria->categoria actualizada exitosamente!",
        'data' => $categoria,
         201
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
      $categoria->delete();
      return response()->json([
          'error' => false,
          'message' => "Categoría $categoria->categoria eliminada exitosamente!",
          'data' => $categoria,
           201
        ]);
    }
}
