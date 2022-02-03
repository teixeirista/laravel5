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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Middleware para impedir que o usuário tenha acesso a essas rotas sem estar logado
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'FileController@show');

    Route::post('/file/create', 'FileController@store');

    Route::get('/files', function () {
        return view('files');
    })->name('files');

    Route::get('/download/{file}', 'FileController@download');
    Route::get('/view/{id}', 'FileController@view');
});

//Route::get('/', 'HomeController@index');
//Route::post('/file/store', 'FileController@store');



/*$this->get('/test-conn', function () {
    // Insere um novo usuário ao banco de dados:
    $user = \App\User::create([
        'name'         => 'Carlos Ferreira',
        'email'     => 'carlos@especializati.com.br',
        'password'     => bcrypt('SenhaAqui'),
    ]);
    // Se quiser exibir os dados do usuário: dd($user);

    // Listando os usuários
    $users = \App\User::get();

    echo '<hr>';
    foreach ($users as $user) {
        echo "{$user->name} <br>";
    }
    echo '<hr>';
});*/