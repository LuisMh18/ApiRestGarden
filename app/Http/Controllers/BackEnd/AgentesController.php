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

class AgentesController extends Controller
{
    use ApiResponser;

    public function __construct(){
        $this->middleware('jwt.auth');
    }

    //listar pedidos que tiene dicho agente
    /*A ls clientes se les asigna un agente, entonces cada pedido de dicho cliente se le va mostrar al agente asignado,
    para los agentes se listan los pedidos donde el estatus es diferente a 4 es decir a 
	Estatus:
	 0 - pendiente
	 1 - credito
	 2 - pagado
	 3 - cancelado
	 4 - 
    */

    public function index(Request $request)
    {
    	$idagente = Auth::user()->id;

    	$data = DB::table('cliente');

    	$orden = ($request->order != '') ? $request->order : 'desc';
        $search = $request->search;

        if($request->has('search')){
            $data->where(function ($query) use ($search) {
                $query->where('num_pedido', 'like', '%'.$search.'%')
                      ->orWhere('numero_cliente',  'like', '%'.$search.'%')
                      ->orWhere('pedido.created_at',  'like', '%'.$search.'%')
                      ->orWhere('nombre_cliente',  'like', '%'.$search.'%');
            });
        }

        if($request->estatus != 4){
            $data->where('estatus',  $request->estatus);
        }


		$data = $data->orderBy('id', $orden)
            ->join('pedido','cliente.id', '=','pedido.cliente_id')
            ->leftJoin('extra_pedido','pedido.id', '=','extra_pedido.pedido_id')
            ->select('pedido.id', 'num_pedido','nombre_cliente', 'paterno','razon_social', 'pedido.total as total' ,'numero_cliente','pedido.created_at','estatus', 'extra_pedido', 'extra_pedido.total as extra_total')
            ->where('cliente.agente_id', $idagente)
            ->where('estatus', '!=', 4)
            //->havingRaw('SUM(pedido.total)')
            //->groupBy('pedido.id')
            ->get();

    	return $this->showAll($data);
    }


}
