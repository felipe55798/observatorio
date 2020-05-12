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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('getAuth', 'UserController@getAuthenticatedUser');
Route::post('logout', 'UserController@logout');

 Route::group(['middleware' => ['jwt.verify']], function() {
       /*AÑADE AQUI LAS RUTAS QUE QUIERAS PROTEGER CON JWT; ES DECIR LAS RUTAS QUE SON PRIVADAS*/
 });
