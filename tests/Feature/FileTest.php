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
    public function check_if_correct_information_about_file_is_received()
    {
        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria um arquivo utilizando o factory
        $file = factory(File::class)->make([
            'name' => 'arquivo',
            'description' => '1 2 testando, 1 2',
            'file' => UploadedFile::fake()->create('file.txt')
        ]);

        //Faz upload do arquivo
        $this->post('/file/create', $file->toArray());

        //Recece as informações do arquivo através da rota de visualização de arquivos
        $content = $this->get('/view/1')->decodeResponseJson();

        //Exclui os itens inerentes à data e hora da criação do arquivo, para facilitar o teste
        $content = array_splice($content, 0, 4);

        //Testa se o JSON recebido é igual ao definido abaixo
        $this->assertEquals(
            [
                "id" => 1,
                "name" => "arquivo",
                "description" => "1 2 testando, 1 2",
                "file" => "arquivo.txt",
            ],
            $content
        );
    }

    /** @test */
    public function a_file_can_be_uploaded()
    {
        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria um arquivo utilizando o factory
        $file = factory(File::class)->make([
            'name' => 'teste de upload',
            'description' => 'Arquivo gerado pelo teste do site',
            'file' => UploadedFile::fake()->create('file.pdf')
        ]);

        //Faz o upload do arquivo
        $response = $this->post('/file/create', $file->toArray());

        //Verifica se o arquivo está no banco de dados
        $this->assertDatabaseHas('files', ['name' => 'teste de upload']);

        //Verifica se o arquivo está no storage
        Storage::disk('public')->assertExists('/files/' . 'teste de upload.pdf');
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
    public function check_if_file_exists_in_database()
    {
        //Cria um usuário
        $user = factory(User::class)->make();
        $this->actingAs($user);

        //Cria um arquivo com nome específico
        $file = factory(File::class)->make([
            'name' => 'Arquivo',
        ]);

        //Faz upload do arquivo
        $this->post('/file/create', $file->toArray());

        //Verifica se o arquivo existe no banco de dados
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
        //Cria dez arquivos e salva no banco de dados
        for ($i = 1; $i <= 10; $i++) {
            factory(File::class)->create();
        }

        //Verifica se a quantidade de arquivos no banco é a esperada
        $this->assertEquals(10, File::count());
    }

    /** @test */
    public function return_all_files()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);

        for ($i = 1; $i <= 10; $i++) {
            factory(File::class)->create();
        }

        $response = $this->get('/home');

        $response->assertStatus(200);
    }
}
