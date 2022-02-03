@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<div class="panel panel-default">
				<div class="panel-heading">Upload de arquivos</div>

				<div class="panel-body">
					@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
					@endif

					<form action="/file/create" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="text" name="name" placeholder="Nome">
						<input type="text" name="description" placeholder="Descrição">
						<input type="file" name="file">
						<br>
						<button type="submit"> Enviar </button>
					</form>

					<!--@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif-->

				</div>
			</div>
		</div>
	</div>
</div>
<!--
	<h2>Upload de Arquivos</h2>
<body>
	<div class="flex-center position-ref full-height">

		<div class="content">
			<form action="/arquivo/store" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="text" name="name" placeholder="Nome:">
				<br>
				<input type="file" name="file">
				<button type="submit"> Enviar </button>
			</form>
		</div>
	</div>
</body>-->
@endsection