@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <main>
                <div class="container-fluid">
                    <div class="row">
                        @if(session('msg'))
                        <p class="msg">{{ session('msg') }}</p>
                        @endif
                    </div>
                </div>
            </main>

            <div class="panel panel-default">
                <div class="panel-heading">Lista de Arquivos</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table border="1px">
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Arquivo</th>
                            <th>Visualizar</th>
                            <th>Baixar</th>
                        </tr>

                        @foreach ($data as $data)
                        <tr>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->file }}</td>
                            <td><a href="{{ url('/view', $data->id) }}">Ver</a></td>
                            <td><a href="{{ url('/download', $data->file) }}">Baixar</a></td>
                        </tr>

                        @endforeach

                    </table>


                    <a href="{{ route('arquivos.create') }}">Cadastrar novo arquivo</a>

                    <!--Você está logado!-->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection