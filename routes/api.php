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

    Route::post('login/{passaport}', 'Security\AuthController@authenticate');
    Route::post('login-refresh', 'Security\AuthController@refreshToken');
    Route::get('me', 'Security\AuthController@getAuthenticatedUser');
    Route::post('refresh', 'Security\AuthController@refresh');
    Route::post('me', 'Security\AuthController@me');

});

Route::group(['name'=>'v1'], function()
{
    Route::apiResource('/v1/lojas','LojaController');
    Route::apiResource('/v1/produtos', 'ProdutoController');
    Route::apiResource('/v1/pedidos', 'PedidoController');
    Route::apiResource('/v1/pedido/{pedido}/produtos', 'PedidoItemController');
});

