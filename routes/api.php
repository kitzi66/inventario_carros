<?php

use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function(){
   Route::post('login', [AuthController::class, 'login']);
   route::group(['middleware' => 'auth:api'], function(){
       Route::get('logout', [AuthController::class, 'logout']);
   });
});

Route::group(['middleware' => 'auth:api'], function (){
    Route::resource('inventarios', InventarioController::class);
}
);

