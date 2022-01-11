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

//Route::get('/', 'HomeController@index');
Route::post('/arquivo/store', 'ArquivoController@store');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'ArquivoController@show')->name('home');

Route::get('/arquivos', function () {
    return view('arquivos');
})->name('arquivos.create');

Route::get('/index', function () {
    return view('index');
});

Route::get('/arquivos/{id}', function () {
    return view('arquivos');
});

Route::get('/download/{file}', 'ArquivoController@download');
Route::get('/view/{id}', 'ArquivoController@view');

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