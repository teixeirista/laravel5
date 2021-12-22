<!DOCTYPE html>
<html lang="en">

<head>
	<title>Lista de arquivos</title>
</head>

<body>

	<table border="1px">
		<tr>
			<th>Name</th>
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
</body>

</html>