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
Route::group(['name'=>'v1'], function()
{
    Route::apiResource('/v1/lojas','LojaController');
    Route::apiResource('/v1/{lojaId}/produtos', 'ProdutoController');
    Route::apiResource('/v1/{lojaId}/pedidos', 'PedidoController');
    Route::apiResource('/v1/{lojaId}/pedido/{pedido}/itens', 'PedidoItemController');
});
//Teste versão
//Route::group(['name'=>'v2'], function()
//{
//    Route::apiResource('/v2/lojas','LojaController');
//});
