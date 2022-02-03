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

Route::post('auth/login', 'Api\\AuthController@login'); //Rota de login
//Route::post('auth/create', 'Api\\AuthController@register'); //Rota de cadastro de usuário
Route::get('/auth/token', 'Api\\AuthController@handle'); //Rota de validação do token

//Middleware para impedir que o usuário tenha acesso a essas rotas sem estar logado
Route::group(['middleware' => ['apiJwt']], function () {
	Route::post('auth/logout', 'Api\\AuthController@logout'); //Rota de logout
	Route::post('/file/create', 'Api\\FileController@store'); //Rota de upload de arquivos
	Route::get('/files', 'Api\\FileController@index'); //Rota de listagem dos arquivos
	Route::get('/file/{id}', 'Api\\FileController@show'); //Rota de visualização de arquivos
});
