<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Pizza;
use App\Http\Resources\Pizza as PizzaResource;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pizzas', function () {
    return PizzaResource::collection(Pizza::all());
});

Route::post('/orders', 'OrderController@store');
Route::get('/orders', 'OrderController@index');
Route::put('/orders/{id}', 'OrderController@update');
Route::patch('/orders/{id}/complete', 'OrderController@complete');
Route::get('/cart', 'OrderController@cart');
Route::delete('/order_items/{id}', 'OrderController@deleteOrderItem');