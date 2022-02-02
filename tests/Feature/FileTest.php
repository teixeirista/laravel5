<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\User;

class FileTest extends TestCase
{
    use RefreshDatabase; //Recarrega o banco de dados toda vez que executa um teste
    //use WithoutMiddleware;

    /** @test */
    /*public function a_test()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
    }*/

    /** @test */
    public function a_file_can_be_uploaded()
    {

        $this->withoutExceptionHandling();

        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria um arquivo
        //$fileUpload = UploadedFile::fake()->create('file.pdf');

        $file = factory(File::class)->make([
            'name' => 'Arquivo de Teste',
            'description' => 'Arquivo gerado pelo teste do site',
            'file' => UploadedFile::fake()->create('file.pdf'), //Salva um e-mail vazio para o usuário
        ]);

        //Faz o upload do arquivo
        //$response = $this->actingAs($user)->post('/file/create', $file->toArray());
        $response = $this->post('/file/create', $file->toArray());

        //dd($response);

        //Verifica se um arquivo está no storage
        //Storage::disk('public')->assertExists('/files/' . '1643744720.txt');
        //Storage::disk('public')->assertExists('1643292505.pdf');

        $response->assertSuccessful();
        // Assert a file does not exist...
        //Storage::disk('public')->assertMissing('/files/' . 'missing.jpg');
    }

    /** @test */
    public function a_name_is_required()
    {

        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria uma instância do model File com o nome inválido
        $file = factory(File::class)->make([
            'name' => ''
        ]);

        //Tenta salvar o arquivo no banco de dados
        $response = $this->post('/file/create', $file->toArray());

        //Testa se a validação detectou erro no campo name
        $response->assertSessionHasErrors('name', $format = null, $errorBag = 'default');
    }

    /** @test */
    public function a_file_is_required()
    {

        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria um arquivo sem o campo arquivo
        $file = factory(File::class)->make([
            'file' => ''
        ]);

        //Faz o upload do arquivo
        $response = $this->post('/file/create', $file->toArray());

        //Testa se houve erro por causa da falta do arquivo
        $response->assertSessionHasErrors('file', $format = null, $errorBag = 'default');
    }

    /** @test */
    public function check_if_correct_information_about_file_is_received()
    {

        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->assertAuthenticated();

        //Cria uma instância do model File com o nome inválido
        $file = factory(File::class)->make([
            'name' => 'arquivo',
            'description' => '1 2 testando, 1 2',
            'file' => UploadedFile::fake()->create('file.txt')
        ]);

        $this->post('/file/create', $file->toArray());

        //$response->assertSuccessful();

        //$id = File::find($file);

        //dd(File::count());

        $content = $this->get('/view/2')->decodeResponseJson();

        //Exclui os itens inerentes à data e hora da criação do arquivo, para facilitar o teste
        $content = array_splice($content, 0, 4);

        //dd($content);

        //Teste se o JSON recebido é igual ao definido abaixo
        $this->assertEquals(
            [
                "id" => 2,
                "name" => "arquivo",
                "description" => "1 2 testando, 1 2",
                "file" => "arquivo.txt",
            ],
            $content
        );
    }

    /** @test */
    public function check_if_file_exists_in_database()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);

        $file = factory(File::class)->make([
            'name' => 'Arquivo',
        ]);

        $this->post('/file/create', $file->toArray());

        $arquivo = File::first();
        $this->assertNotNull($arquivo->file);
        $this->assertEquals('Arquivo', $arquivo->name);

        $this->assertDatabaseHas('files', ['name' => 'Arquivo']);
    }

    /** @test */
    public function check_if_file_exists_in_storage()
    {
        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria um arquivo
        $file = factory(File::class)->make([
            'name' => 'arquivo de teste',
            'description' => 'arquivo gerado pelo teste do site',
        ]);

        //Faz o upload do arquivo
        $this->post('/file/create', $file->toArray());

        //Testa se o arquivo criado está no storage
        Storage::disk('public')->assertExists('/files/' . 'arquivo de teste.pdf');
    }

    /** @test */
    public function count_files()
    {
        //$user = factory(User::class)->make();
        //$this->actingAs($user);

        for ($i = 1; $i <= 10; $i++) {
            factory(File::class)->create();
        }

        $this->assertEquals(10, File::count());
    }
}
