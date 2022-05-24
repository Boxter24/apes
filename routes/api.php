<?php

use App\Http\Controllers\API\CategoriasController;
use App\Http\Controllers\API\FacultadesController;
use App\Http\Controllers\API\CarrerasController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::get('/', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');

Route::resource('categorias', API\CategoriasController::class);

Route::resource('facultades', API\FacultadesController::class);

Route::resource('carreras', API\CarrerasController::class);

Route::resource('secciones', API\SeccionesController::class);

Route::resource('detalles', API\DetallesController::class);

Route::resource('colores', API\ColoresController::class);

Route::resource('carrusel', API\CarruselController::class);

Route::resource('informaciones', API\InformacionesController::class);

Route::resource('foros', API\ForosController::class)->middleware('auth:api');

Route::resource('comentarios', API\ComentariosController::class)->middleware('auth:api');




