<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>

<body>
	{{ $data->name }}
	<br>
	{{ $data->description }}
	<br>

	<iframe height="500" width="900" src="/storage/files/{{ $data->file }}" frameborder="0"></iframe>
</body>

</html>