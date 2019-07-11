<!DOCTYPE html>
<html lang="es">
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
	$sqlEdit = "SELECT * FROM usuario WHERE id = $id";
	$resultEdit = mysqli_query($conexion,$sqlEdit);
	$fila = mysqli_fetch_assoc($resultEdit);
	//calculo los creditos del usuario
	$sqlReservas=mysqli_query($conexion,"SELECT * FROM reserva WHERE id_usuario = $id");
    $reservas=mysqli_num_rows($sqlReservas);
    $creditos=(2 -$reservas);

?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modificación de cuenta</title>
	<link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style_crudResidencia.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style="background-image: url('images/hero_1.jpg');">
<nav style="background-image: url('images/hero_1.jpg'); height: 70px; border-bottom: solid 1px black; " class="navbar navbar-expand-lg navbar-light bg-light">
	 <div class="col-2">
              	<a class="navbar-brand" href="index.php">
				    <img style="margin-top: -30px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
				  </a>
              </div>
</nav>



<div class="container">
	<div class="">
		<h4 class="m-3"><b>Datos personales</b></h4>
	</div>
	<div class="row">
		<div class="container-fluid d-flex justify-content-center">
			
			<form class="ml-5" name="frm" method="post" action="">
				  <div class="form-group row">
				    <label style="color: white; text-shadow: 1px 1px black;" for="inputApellido" class="col-sm-5 col-form-label ml-2">Apellido</label>
				    <div class="col-sm-8">
				        <span class="form-control" name="apellido" id="inputApellido"><?php echo $fila['apellido'];?></span>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label style="color: white; text-shadow: 1px 1px black;" for="inputNombre" class="col-sm-5 col-form-label ml-2">Nombre</label>
				    <div class="col-sm-8">
				      <span class="form-control" name="nombre" id="inputNombre"><?php echo $fila['nombre'];?></span>
				    </div>
				  </div>
				  <div class="form-group row">
				    <label style="color: white; text-shadow: 1px 1px black;" for="inputEmail" class="col-sm-5 col-form-label ml-2">Email</label>
				    <div class="col-sm-8">
				        <span class="form-control" name="email" id="inputEmail"><?php echo $fila['email'];?></span>
				    </div>
				  </div>
				  <div class="form-group row" style="display: inline-block;">
					    <div class="col-sm-12">
					    	<label style="color: white; text-shadow: 1px 1px black;" for="inputTarjeta" class="col-form-label">Tarjeta de credito</label>
					        <span id="inputTarjeta" name="tarjeta" class="form-control"><?php echo $fila['tarjeta_credito'];?></span>
					    </div>
				  </div>
				  <div class="form-group row" style="display: inline-block;">
					    <div class="col-sm-9">
				    	   	<label style="color: white; text-shadow: 1px 1px black;" for="inputSeguro" class="col-form-label">N° de seguridad</label>
				    	    <span style="width: 100px;" id="inputSeguro" name="seguro" class="form-control"><?php echo $fila['numero_seguridad'];?></span>
				    	</div>		    
				  </div>	 
				  <br>
				  <div class="form-group row">
				  	<div class="col-sm-1">
				    <label style="color: white; text-shadow: 1px 1px black;" for="inputCreditos" class="col-form-label">Creditos disponibles</label>
				    
				        <span class="form-control" name="creditos" id="inputCreditos"><?php echo $creditos;?></span>
				    </div>
				  </div>
				  <div class="modal-footer">
						<a href="index.php"><input style="margin-right: 100%;" type="button" class="btn btn-info" value="Atras"></a>
				  </div>
				</form>
		</div>
	</div>
</div>
</body>
</html> 