<!DOCTYPE html>
<html lang="es">
<?php
    Include("DB.php");
	$conexion = conectar();			
	require_once('Authentication.php');
	$authentication = new Authentication();	
	$authentication -> login();	
	if ($authentication ->siLogueado()){//si esta logueado y accede a login.php 
		header('Location:index.php');//se redirecciona al backend
	}	
?>
<head>
	<title>Iniciar Sesión</title>

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
    <a href=""><button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Volver a HSH</button></a>
</nav>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Iniciar Sesión</h3>
			</div>
			<div class="card-body">
				<form action="#" onsubmit="return validarLogin();">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" id="userLogin" name="user" class="form-control" placeholder="Correo electrónico">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" id="passLogin" name="pass" class="form-control" placeholder="Contraseña">
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox">Recuérdame
					</div>
					<div class="form-group">
						<input type="submit" value="Entrar" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿No tienes una cuenta?<a href="registrarse.php">Regístrate</a>
				</div>
				<!-- <div class="d-flex justify-content-center">
					<a href="#">¿Olvidaste tu contraseña?</a>
				</div> -->
			</div>
		</div>
	</div>
</div>
</body>

<script type="text/javascript" src="js/validarLogin.js"></script>	

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>