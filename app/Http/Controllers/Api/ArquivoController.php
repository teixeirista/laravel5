<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

/**
 * Controla as operações relacionadas aos arquivos carregados pelo usuário
 */
class ArquivoController extends Controller
{
    public function index()
    {
        $arquivos = Storage::disk('public')->files('files');

        $data = File::all();

        return response()->json($data);

        //return response()->compact($data);
    }

    /**
     * Salva um recurso recém criado no storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ //Valida as informçaões do formulário de envio de arquivos
            'name' => 'required|min:3|max:255',
            'file' => 'required'
        ]);

        /*if ($request->file('file')->isValid()) {
            $filename = time() . '.' . $request->file->extension();
            //Armazena o arquivo na pasta storage/public
            $request->file('file')->storeAs('files', $filename);

            return 'Arquivo carregado'; //Retorna a mensagem de confirmação de upload
        }*/

        $data = new File();

        if ($request->file('file')->isValid()) {
            //Salva o nome do arquivo como a hora em que ele foi upado junto com a extensão
            $filename = time() . '.' . $request->file->extension();

            //Adiciona os atributos do arquivo na variável que será salva no banco
            $data->name = $request->name;
            $data->description = $request->description;
            $data->file = $filename;

            //Armazena o arquivo na pasta storage/public
            $request->file('file')->storeAs('files', $filename);

            //Salva o arquivo no banco de dados
            $data->save();

            //Retorna a mensagem de confirmação de upload
            return 'Arquivo carregado';

            //return redirect('/home')->with('msg', 'Arquivo carregado');
        }

        return 'O arquivo não pode ser carregado';
    }

    public function show($id)
    {
        $data = File::find($id); //Encontra o arquivo no banco de dados a partir do id
        return response()->json($data);
    }
}
