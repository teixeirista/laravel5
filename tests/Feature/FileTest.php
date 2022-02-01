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
    //use RefreshDatabase; //Recarrega o banco de dados toda vez que executa um teste
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

        //Verifica se o arquivo está inserido no storage
        //Storage::disk('local')->assertExists('files/' . 'missing.jpg');
        Storage::disk('public')->assertExists('/files/' . '1643744720.txt');
        //Storage::disk('public')->assertExists('1643292505.pdf');

        // Assert a file does not exist...
        Storage::disk('public')->assertMissing('missing.jpg');
    }

    /** @test */
    public function a_name_is_required()
    {
        //Cria um arquivo utilizando o Faker
        $fileUpload = UploadedFile::fake()->create('file.pdf');

        //Cria uma instância do model File com o nome inválido
        $file = factory(File::class)->create([
            'name' => '',
            'file' => $fileUpload
        ]);

        //Tenta salvar o arquivo no banco de dados
        $response = $this->post('/file/create', $file->toArray());

        //Testa se a validação detectou erro no campo name
        $response->assertSessionHasErrors('name', $format = null, $errorBag = 'default');
    }

    /** @test */
    public function a_file_is_required()
    {

        $file = factory(File::class)->create([
            'file' => ''
        ]);

        $response = $this->post('/file/create', $file->toArray());

        $response->assertSessionHasErrors('file', $format = null, $errorBag = 'default');
    }

    /** @test */
    public function check_if_correct_information_about_file_is_received()
    {

        //$this->withoutExceptionHandling();

        $user = factory(User::class)->make();
        $this->actingAs($user);

        $fileUpload = UploadedFile::fake()->create('file.pdf');

        //Cria uma instância do model File com o nome inválido
        $file = factory(File::class)->make([
            'name' => 'Arquivo',
            'file' => $fileUpload
        ]);

        $response = $this->post('/file/create', $file->toArray());

        $content = $this->actingAs($user)->get('/view/1')->decodeResponseJson();

        $this->assertEquals(
            [
                "id" => 1,
                "name" => "texto",
                "description" => "arquivo de texto",
                "file" => "1643737177.txt",
                "created_at" => "2022-02-01 14:39:37",
                "updated_at" => "2022-02-01 14:39:37"
            ],
            $content
        );
    }

    /** @test */
    public function check_if_file_exists_in_database()
    {
        //Storage::fake('public');

        //$user = User::factory()->create();
        $user = factory(User::class)->make();
        $this->actingAs($user);

        $file = factory(File::class)->create([
            'name' => 'Arquivo',
            'file' => UploadedFile::fake()->create('file.pdf')
        ]);

        $this->post('/file/create', $file->toArray());

        /*$this->post('/file/create', [
            'name' => 'Arquivo',
            'file' => $file
        ]);*/

        $arquivo = File::first();
        $this->assertNotNull($arquivo->file);
        $this->assertEquals('Arquivo', $arquivo->name);

        //Storage::disk('files')->assertExists($arquivo->file);

        $this->assertDatabaseHas('files', ['name' => 'Arquivo']);

        //$this->assertFileEquals($file, Storage::disk('files')->path($arquivo->file));
    }
}
