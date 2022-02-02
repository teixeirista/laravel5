<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

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
			'description' => '',
			'file' => 'required'
		]);

		$data = new File();

		if ($request->file('file')->isValid()) {
			//Salva o nome do arquivo como a hora em que ele foi upado junto com a extensão
			//$filename = time() . '.' . $request->file->extension();
			$filename = $request->name . '.' . $request->file->extension();


			//Adiciona os atributos do arquivo na variável que será salva no banco
			$data->name = $request->name;
			$data->description = $request->description;
			$data->file = $filename;

			//Armazena o arquivo na pasta storage/public
			$request->file('file')->storeAs('files', $filename);

			//Salva o arquivo no banco de dados
			$data->save();

			//Retorna a mensagem de confirmação de upload
			//return redirect('/home')->with('msg', 'Arquivo carregado');
			return "Arquivo carregado";
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show()
	{
		$data = File::all();
		//return view('showfiles', compact('data'));
		return view('home', compact('data'));
		//return response()->json($data);
	}

	public function download(Request $request, $file)
	{
		//return response(Storage::download($file));
		return response()->download(public_path('assets/' . $file));
	}

	public function view($id)
	{
		$data = File::find($id);

		//dd($data);

		if ($data != null) {
			return $data->toJson();
			//return view('viewfile', compact('data'));
		}

		return ['msg' => "Arquivo não encontrado"];
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
