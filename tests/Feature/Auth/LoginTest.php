<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    //Recarrega o banco de dados toda vez que executa um teste
    use RefreshDatabase;

    //Testa se um usuário consegue ver a tela de login
    /** @test */
    public function user_can_view_login_form()
    {
        //Faz uma requisição para a tela de login e salva a resposta
        $response = $this->get('/login');

        //Testa se a página carregou com sucesso
        $response->assertSuccessful();
        //Testa se a tela é a correta
        $response->assertViewIs('auth.login');
        //Testa se o usuário não está autenticado
        $this->assertGuest();
    }

    //Testa se um usuário não consegue visualizar a tela de login se já estiver autenticado
    /** @test */
    public function user_cannot_view_login_form_when_authenticated()
    {
        //Cria um usuário para usar no teste
        $user = factory(User::class)->make();

        //Tenta realizar um login utilizando o usuário criado
        $response = $this->actingAs($user)->get('/login');

        //Testa se o usuário foi redirecionado para a home, ou seja, logou
        $response->assertRedirect('/home');
    }

    //Testa se um usuário não consegue visualizar a lista de arquivos caso não esteja autenticado
    /** @test */
    public function user_cannot_view_home_without_authenticate()
    {
        $response = $this->get('/home'); //Faz uma requisição para a tela de arquivos e salva a resposta

        $response->assertRedirect('/login');
        //$response->assertViewIs('auth.login'); //Testa se a tela é a correta
    }

    //Testa se um usuário consegue logar corretamente
    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([ //Cria um novo usuário e o salva no banco de dados
            'password' => bcrypt($password = 'i-love-laravel'), //Salva uma senha para o usuário
        ]);

        $response = $this->post('/login', [ //Tenta realizar o login com as informações do usuário recém-criado
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home'); //Testa se foi redirecionado para a tela home
        $this->assertAuthenticatedAs($user); //Testa se o usuário está autenticado
    }

    //Testa se um usuário não consegue logar com a senha incorreta
    /** @test */
    public function user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([ //Cria um novo usuário e o salva no banco de dados
            'password' => bcrypt('i-love-laravel'), //Salva uma senha para o usuário
        ]);

        //Tenta realizar o login com as informações do usuário recém-criado, mas com a senha incorreta
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login'); //Testa se foi redirecionado para a tela de login novamente
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email')); //Testa se o e-mail digitado pelo usuário ainda está no campo de texto
        $this->assertFalse(session()->hasOldInput('password')); //Testa se a senha digitada pelo usuário não está mais no campo de texto
        $this->assertGuest(); //Testa se o usuário não foi autenticado e continua como convidado
    }

    //Testa se um usuário não consegue logar sem senha
    /** @test */
    public function user_cannot_login_without_password()
    {
        $user = factory(User::class)->create([ //Cria um novo usuário e o salva no banco de dados
            'password' => bcrypt('i-love-laravel'), //Salva uma senha para o usuário
        ]);

        //Tenta realizar o login com as informações do usuário recém-criado, mas sem a senha
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => '',
        ]);

        $response->assertRedirect('/login'); //Testa se foi redirecionado para a tela de login novamente
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('email')); //Testa se o e-mail digitado pelo usuário ainda está no campo de texto
        $this->assertFalse(session()->hasOldInput('password')); //Testa se a senha digitada pelo usuário não está mais no campo de texto
        $this->assertGuest(); //Testa se o usuário não foi autenticado e continua como convidado
    }

    //Testa se um usuário não consegue logar sem informar o e-mail
    /** @test */
    public function user_cannot_login_without_email()
    {
        $user = factory(User::class)->create([ //Cria um novo usuário e o salva no banco de dados
            'email' => ' ', //Salva um e-mail vazio para o usuário
            'password' => bcrypt('i-love-laravel'), //Salva uma senha para o usuário
        ]);

        //Tenta realizar o login com as informações do usuário recém-criado, mas com a senha incorreta
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertRedirect('/login'); //Testa se foi redirecionado para a tela de login novamente
        $response->assertSessionHasErrors('email');
        //$this->assertTrue(session()->hasOldInput('email')); //Testa se o e-mail digitado pelo usuário ainda está no campo de texto
        $this->assertFalse(session()->hasOldInput('password')); //Testa se a senha digitada pelo usuário não está mais no campo de texto
        $this->assertGuest(); //Testa se o usuário não foi autenticado e continua como convidado
    }

    //Testa se um usuário consegue fazer logout corretamente
    /** @test */
    public function user_can_logout()
    {
        //Cria um usuário
        $user = factory(User::class)->make();

        //Realiza o login utilizando o usuário criado
        $response = $this->actingAs($user)->get('/login');

        //Verifica se o usuário está autenticado
        $this->assertAuthenticated();

        //Realiza o logout
        $response = $this->post('/logout');

        //Testa se foi redirecionado para a tela welcome
        $response->assertRedirect('/');
        //Testa se o usuário não está mais autenticado
        $this->assertGuest();
    }

    //Testa se um usuário não consegue acessar a lista de arquivos depois de deslogar
    /** @test */
    public function user_has_no_access_after_logout()
    {
        //Cria um usuário
        $user = factory(User::class)->make();

        //Realiza o login utilizando o usuário criado
        $response = $this->actingAs($user)->get('/login');

        //Verifica se o usuário está autenticado
        $this->assertAuthenticated();

        //Realiza o logout
        $response = $this->actingAs($user)->post('/logout');

        //Testa se foi redirecionado para a tela welcome
        $response->assertRedirect('/');
        //Testa se o usuário não está mais autenticado
        $this->assertGuest();

        //Tenta ver a lista de arquivos
        $response = $this->get('/home');

        //Verifica se foi redirecionado para a página de login
        $response->assertRedirect('/login');
    }
}
