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
    Route::get('/home', 'ArquivoController@show');

    Route::get('/arquivos', function () {
        return view('arquivos');
    })->name('arquivos.create');

    Route::get('/download/{file}', 'ArquivoController@download');
    Route::get('/view/{id}', 'ArquivoController@view');
});

//Route::get('/', 'HomeController@index');
Route::post('/arquivo/store', 'ArquivoController@store');



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