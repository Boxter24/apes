<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;
//WELCOME
Route::get('/', 'WelcomeController@index')->where( 'path', '([A-z\d\-/_.]+)?' )->name('inicio');
    

//AUTENTICACION
Auth::routes();
//User
Route::get('/inicio','HomeController@index')->where( 'path', '([A-z\d\-/_.]+)?' )->name('inicio');
//Admin
Route::get('/home','HomeController@index')->where( 'path', '([A-z\d\-/_.]+)?' )->name('home');
//Rutas generales
Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d\-/_.]+)?' );




