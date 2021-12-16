<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * Controla as operações relacionadas aos arquivos carregados pelo usuário
 */
class ArquivoController extends Controller
{
    public function index()
    {
        $arquivos = Storage::disk('public')->files('files');
        return response()->json($arquivos);
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

        if ($request->file('file')->isValid()) {
            //Armazena o arquivo na pasta storage/public
            $request->file('file')->storeAs('files', $request->name);

            return 'Arquivo carregado'; //Retorna a mensagem de confirmação de upload
        }
    }
}
