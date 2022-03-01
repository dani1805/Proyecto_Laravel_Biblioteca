<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('usuarios/registrar', 'UsuarioController@store');

Route::get('libros', 'LibroController@index');

Route::get('libros/{libro}', 'LibroController@show');

// Rutas protegidas

Route::group([
    'middleware' => ['auth.api']
], function () {

    Route::post('usuarios/{usuario}/prestar', 'UsuarioController@prestar');

    Route::post('libros/nuevo', 'LibroController@store');

    Route::delete('libros/{libro}/borrar', 'LibroController@destroy');

    Route::post('libros/{libro}/modificar', 'LibroController@update');

});





