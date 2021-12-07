<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArquivoController extends Controller
{
    public function index()
    {
        $arquivos = Storage::disk('public')->files('files');
        return response()->json($arquivos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'file' => 'required'
        ]);

        if ($request->file('file')->isValid()) {
            $nameFile = $request->name . '.' . $request->file->extension();
            $request->file('file')->storeAs('files', $nameFile);

            return 'Arquivo carregado';
        }
    }
}
