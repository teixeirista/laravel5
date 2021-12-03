@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">Lista de Arquivos</div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <ul class="list-group">
                        @foreach ($arquivos as $arquivo)
                        <li class="list-group-item">{{ str_replace('files/', '', $arquivo) }}</li>
                        @endforeach
                    </ul>

                    <a href="{{ route('arquivos.create') }}">Cadastrar novo arquivo</a>

                    <!--Você está logado!-->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection