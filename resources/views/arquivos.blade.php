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
</body>