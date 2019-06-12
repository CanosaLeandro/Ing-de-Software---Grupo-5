<!DOCTYPE html>
<html lang="en">
	<?php
	Include("DB.php"); $conexion = conectar(); 
	/*aca valida si inicio sesion--------------------------------------------*/
	require_once('Authentication.php');
	$authentication = new Authentication();	
	$authentication->login();						
	try{				
		$authentication->logueado();
	}catch(Exception $ex){
		$error = $ex->getMessage();
		echo "<script>alert('$error');</script>";
		echo "<script>window.location = 'home.php';</script>";
	}		

	/*----------------------------------------------------------------------------*/

	$id = $_SESSION['id'];


	?>
  <head>
    <title>HSH &mdash; Inicio</title>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración de Usuarios</title>
	<link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style_crudResidencia.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
  </head>
  <body>  
  
  <!-- menu cabecera -->
  

	    
	    
	   <nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand" href="index.php">
		    <img style="margin-top: -8px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="mb-3 d-inline-block align-top" alt="">
		  </a>
		</nav>
	  

<br>
<br>
<div class="container-fluid">
<?php
if (isset($_GET['solicitud'])) {
	echo '<div class="alert alert-success" role="alert">
			  <h4 class="alert-heading">Solicitud enviada!</h4>
			  <p>La solicitud fue enviada correctamente, en la brevedad nos comunicaremos con usted. Saludos</p>
			  <hr>
			  <p class="mb-0">El equipo de Home Switch Home.</p>
			</div>';
}
else{
	echo '<div class="alert alert-success" role="alert">
			  <h4 class="alert-heading">Felicitaciones!</h4>
			  <p>Su solicitud de suscripción fue aceptada, ya puede usar todas las funcionalidades que le ofrece Home Switch Home.</p>
			  <hr>
			  <p class="mb-0">Gracias por suscribirse. Ahora puede hacer hasta dos reservas en forma directa por este año.</p>
			  <hr>
			  <p class="mb-0">El equipo de Home Switch Home.</p>
			</div>';
		mysqli_query($conexion, "UPDATE usuario SET actualizar = 'si' WHERE id = $id");
	}
 ?>

 <button style='color: #FF00ff; align-items: center;' id='' class='btn btn-primary'><a href='index.php' style="text-decoration: none; color:white;">Ir a Home Switch Home</a></button>
 </div>

</body>
</html>
