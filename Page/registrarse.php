<!DOCTYPE html>
<html lang="es">
<head>
	<title>Registro</title>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 

   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 

    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">
    <img src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    Home Switch Home
  </a>
	<a href="login.php"><button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Iniciar Sesión</button></a>
</nav>
<div class="container-fluid">
	<div class="">
				<h4 class="m-3">Registro</h4>
			</div>
	<div class="row">
		<div class="col-4"></div>
		<div class="d-flex justify-content-center">
			<form>
				  <div class="form-group row">
				    <label for="inputEmail3" class="col-sm-5 col-form-label ml-2">Email</label>
				    <div class="col-sm-10">
				      <input type="email" class="form-control" id="inputEmail3" placeholder="Escribá aquí su correo electrónico" required>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword3" class="col-sm-5 col-form-label ml-2">Contraseña</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" id="inputPassword3" placeholder="" aria-describedby="passwordHelpBlock" required>
				      <small id="passwordHelpBlock" class="form-text text-muted">
						  Su contraseña debe contener un mínimo de 4 caracteres.
						</small>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword4" class="col-sm-5 col-form-label ml-2">Confirmar contraseña</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" id="inputPassword4" placeholder="" required>
				    </div>
				  </div>	  
				  <div class="form-group row">
				    <label for="inputTarjeta" class="col-sm-5 col-form-label ml-2">Tarjeta de credito</label>
				    <div class="col-sm-10">
				      <input type="number" class="form-control" id="inputTarjeta" placeholder="Ingrese el número de la tarjeta aquí" required>
				    </div>
				  </div>	 
				  <div class="form-group row">
				    <div class="col-sm-10">
				      <button type="submit" class="btn btn-primary">Crear Cuenta</button>
				    </div>
				  </div>
				</form>
		<div/>
		</div>
	</div>


</div>
</body>	
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>