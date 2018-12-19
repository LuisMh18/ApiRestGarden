<?php

namespace App\Http\Controllers\BackEnd;

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

class InventarioController extends Controller
{
    use ApiResponser;

    public function index(Request $request){


    	$data = DB::table('producto');

        $orden = ($request->order != '') ? $request->order : 'desc';
        $search = $request->search;

        if($request->has('search')){
            $data->where(function ($query) use ($search) {
                $query->where('clave', 'like', '%'.$search.'%')
                      ->orWhere('nombre',  'like', '%'.$search.'%')
                      ->orWhere('cantidad',  'like', '%'.$search.'%')
                      ->orWhere('num_pedimento',  'like', '%'.$search.'%')
                      ->orWhere('inventario_detalle.created_at',  'like', '%'.$search.'%');
            });
        }


        $data = $data->orderBy('id', $orden)
        ->join('inventario_detalle','producto.id','=','inventario_detalle.producto_id')
		->select('inventario_detalle.id', 'producto.id as id_producto', 'clave','nombre','cantidad', 'num_pedimento', 'inventario_detalle.created_at', 'foto')
        ->get();

        return $this->showAll($data);

    }
}
