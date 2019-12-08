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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login/{passaport}/admin', 'Security\AuthController@authenticate');
    Route::post('login/{passaport}', 'Security\AuthController@authenticate');
    Route::post('login-refresh', 'Security\AuthController@refreshToken');
    Route::get('me', 'Security\AuthController@getAuthenticatedUser');
    Route::post('refresh', 'Security\AuthController@refresh');
    Route::post('logout', 'Security\AuthController@logoutToken');
});

Route::group([
    'name'=>'v1',
    'middleware' => 'jwt.verify',
    'prefix' => 'v1'
], function()
{
    Route::apiResource('lojas','LojaController');
    Route::apiResource('produtos', 'ProdutoController')->middleware('protection.v1.produtos');
    Route::apiResource('pedidos', 'PedidoController')->middleware('protection.v1.pedidos');
    Route::apiResource('pedido/{pedido}/produtos', 'PedidoItemController')->middleware('protection.v1.pedidos.produtos');

//Implementar no controler no final
//    Route::post('/v1/compas/pedidos', 'PedidoController@compas');
//    Route::post('/v1/compas/pedidos/{pedido}', 'PedidoController@compa');
});

