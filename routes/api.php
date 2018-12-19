<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


//Login
Route::post('login', 'AuthenticateController@login');
Route::get('logout', 'AuthenticateController@logout');


//Rutas para los clientes -- front --
Route::group(['middleware' => ['front']], function(){
	Route::get('clientes/categorias', 'FrontEnd\UsersController@categorias');
	Route::resource('clientes', 'FrontEnd\UsersController');
	Route::post('clientes/index', 'FrontEnd\UsersController@index');//busquedas y ordenacion de resultado
});


//rutas para los agentes -- backend --
Route::group(['middleware' => ['agente']], function(){
	Route::post('agentes', 'BackEnd\AgentesController@index');//busquedas y ordenacion de resultados
	Route::get('agentes/verPedido/{id_pedido}/{id_cliente}', 'BackEnd\AgentesController@verPedido');//busquedas y ordenacion de resultados
});


//rutas para el admin -- backend --
Route::group(['middleware' => ['admin']], function(){
	//Almacen
	Route::get('admin/almacen/data', 'BackEnd\AlmacenController@data');//todos los resultados
	Route::resource('admin/almacen', 'BackEnd\AlmacenController', ['except' => ['create', 'edit']]);
	Route::post('admin/almacen/index', 'BackEnd\AlmacenController@index');//busquedas y ordenacion de resultados
	//Comercializador
	Route::get('admin/comercializador/data', 'BackEnd\ComercializadorController@data');//todos los resultados
	Route::resource('admin/comercializador', 'BackEnd\ComercializadorController', ['except' => ['create', 'edit']]);
	Route::post('admin/comercializador/index', 'BackEnd\ComercializadorController@index');
	//categoria
	Route::get('admin/categorias/data', 'BackEnd\CategoriasController@data');//todos los resultados
	Route::resource('admin/categorias', 'BackEnd\CategoriasController', ['except' => ['create', 'edit']]);
	Route::post('admin/categorias/index', 'BackEnd\CategoriasController@index');
	//usuarios
	Route::get('admin/usuarios/data', 'BackEnd\UsuariosController@data');//todos los resultados
	Route::get('admin/usuarios/rol', 'BackEnd\UsuariosController@roles');//roles de usuario
	Route::resource('admin/usuarios', 'BackEnd\UsuariosController', ['except' => ['create', 'edit']]);
	Route::post('admin/usuarios/index', 'BackEnd\UsuariosController@index');

	//Inventario
	Route::post('admin/inventario', 'BackEnd\InventarioController@index');//todos los resultados

});
