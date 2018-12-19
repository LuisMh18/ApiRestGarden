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
            ->select('pedido.id', 'cliente.id as id_cliente',  'num_pedido','nombre_cliente', 'paterno','razon_social', 'pedido.total as total' ,'numero_cliente','pedido.created_at','estatus', 'extra_pedido', 'extra_pedido.total as extra_total')
            ->where('cliente.agente_id', $idagente)
            ->where('estatus', '!=', 4)
            //->havingRaw('SUM(pedido.total)')
            //->groupBy('pedido.id')
            ->get();

    	return $this->showAll($data);
    }


    public function verPedido(Request $request){
    	$id_pedido = $request->id_pedido;
    	$id_cliente = $request->id_cliente;
    	$id_user = Auth::user()->id;
    	$data = [];
    	/*
    	  obtenemos el nivel de descuento
    	  el id del producto detalle,
    	  la forma de pago,
    	  mensajeria,
    	  id de la dirección del cliente
    	*/
    	$data['datos_cliente'] = DB::table('cliente')
            ->join('nivel_descuento', 'cliente.nivel_descuento_id', '=', 'nivel_descuento.id')
            ->join('pedido','cliente.id', '=','pedido.cliente_id')
            ->join('pedido_detalle','pedido.id', '=','pedido_detalle.pedido_id')
            ->join('forma_pago','pedido.forma_pago_id', '=','forma_pago.id')
            ->join('mensajeria','pedido.mensajeria_id', '=','mensajeria.id')
            ->leftJoin('direccion_cliente','pedido.direccion_cliente_id', '=','direccion_cliente.id')
            ->where('cliente.id', $id_cliente)
            ->select(
            	'nivel_descuento.descripcion as nivel_descuento', 
            	'pedido_detalle.id as pedido_detalle_id', 'pedido.created_at as fecha','num_pedido', 
            	'forma_pago_id','forma_pago.descripcion as forma_pago',
            	'mensajeria_id', 'nombre as mensajeria',
            	'direccion_cliente_id'
            )
            ->first();

            //comprobamos si el cliente tiene direccion(si su compra fue a domicilio) o si su compra fue en recoger en tienda
            
            if($data['datos_cliente']->direccion_cliente_id == 0) {//si no tiene dirección
			    //return response()->json("No tiene dirección");
			    $data['direccion'] = false;
	            $data['cliente_pedido_direccion'] = DB::table('cliente')
	            ->join('pedido', 'cliente.id', '=', 'pedido.cliente_id')
	            ->join('usuario', 'cliente.usuario_id', '=', 'usuario.id')
	            ->where("pedido.id", $id_pedido)
	            ->first();

			} else { //si tiene dirección
				$data['direccion'] = true;
	            $data['cliente_pedido_direccion'] = DB::table('cliente')
	                ->join('direccion_cliente', 'cliente.id', '=', 'direccion_cliente.cliente_id')
	                ->join('pedido', 'cliente.id', '=', 'pedido.cliente_id')
	                ->join('usuario', 'cliente.usuario_id', '=', 'usuario.id')
	                ->join('pais', 'direccion_cliente.pais_id', '=', 'pais.id')
	                ->join('estado', 'direccion_cliente.estado_id', '=', 'estado.id')
	                ->join('municipio', 'direccion_cliente.municipio_id', '=', 'municipio.id')
	                ->join('telefono_cliente', 'direccion_cliente.telefono_cliente_id', '=', 'telefono_cliente.id')
	                ->where("direccion_cliente.id", $data['datos_cliente']->direccion_cliente_id)
	                ->first();
			}

			//productos del pedido
            $data['producto'] = DB::table('producto')
                ->join('pedido_detalle','producto.id', '=','pedido_detalle.producto_id')
                ->where('pedido_detalle.pedido_id', $id_pedido)
                ->select('producto.id', 'clave', 'nombre', 'color', 'precio','iva0', 'cantidad', 'foto', 'num_pedimento')
                ->get();



       /* $data['pedido_detalle'] = DB::table('pedido_detalle')
                    ->join('producto','pedido_detalle.producto_id', '=','producto.id')
                    ->where('pedido_detalle.id', $data['datos_cliente']->pedido_detalle_id)->get();*/



    	return response()->json($data,200);
    }


}
