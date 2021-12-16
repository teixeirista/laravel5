<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controla as operações relacionadas aos arquivos carregados pelo usuário
 */
class ArquivoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
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
			//Salva o nome do arquivo junto com a extensão
			$nameFile = $request->name . '.' . $request->file->extension();
			//Armazena o arquivo na pasta storage/public
			$request->file('file')->storeAs('files', $nameFile);

			return "Arquivo carregado"; //Retorna a mensagem de confirmação de upload
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
