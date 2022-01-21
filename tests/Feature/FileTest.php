<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileTest extends TestCase
{
    use RefreshDatabase; //Recarrega o banco de dados toda vez que executa um teste

    /** @test */
    /*public function a_file_can_be_uploaded()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.pdf');

        $response = $this->post('/file/create', [
            'name' => 'arquivo 123',
            'description' => 'teste de arquivo',
            'file' => $file
        ]);

        $this->assertCount(1, File::all());
    }

    /** @test */
    /*public function a_name_is_required()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.pdf');

        $response = $this->post('/file/create', [
            'name' => '',
            'description' => 'teste de arquivo',
            'file' => $file
        ]);

        $response->assertJsonValidationErrors('name');
    }*/
}
