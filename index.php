<!DOCTYPE html>
<html lang="ES">

<head>
	<meta charset="utf-8">
	<title>Inicia sesión</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="css/Index.css">
	<link rel="stylesheet" type="text/css" href="cssBootstrap/bootstrap.css">
</head>

<body>
	<div class="container-md">

		<div class="row">

			<div class="col-8">
				<form action="php/ValidacionLogin.php" method="post">

					<h1>Inicio de sesión</h1>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Usuario</label>
						<input required name="usuario" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Contraseña</label>
						<input required name="contraseña" type="password" class="form-control" id="exampleInputPassword1">
					</div>
					<button type="submit" class="btn btn-primary">Ingresar</button>
				</form>
				</form>

			</div>
		</div>
	</div>
</body>

</html>
