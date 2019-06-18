<!DOCTYPE html>
<html lang="en">
  <?php Include("DB.php"); $conexion = conectar();

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

	$idUser = $_SESSION['id'];
 ?>
  <head>
    <title>HSH &mdash; Residencias</title>
    <meta charset="utf-8">
    <?php
      require('links.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   
    
  </head>
 <body style="background-image: url('images/beach.jpg');">

	<?php


	 	$queryReservas = "SELECT DISTINCT id_residencia FROM reserva WHERE id_usuario = $idUser";
	 	$resultadoReservas = mysqli_query($conexion, $queryReservas);
	
	 	
	?>
    <!-- Page Content -->
	<div class="container">
		<div class="py-2">
			<div class="row align-items-center text-center">
		      <div class="col-2">
	          	<a class="navbar-brand" href="index.php">
				    <img style="margin-top: -25px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
				  </a>
	          </div>
				
			</div>
		<div class="col">
			<h1 style="color: white; text-shadow: 1px 2px black;" class='page-item' align ='center'>Propiedades reservadas</h1>
		</div>
		<br>
		<br>
	 	</div>

	  <div class="row">
	  <?php
		while($registro = mysqli_fetch_assoc($resultadoReservas)){
			$id = $registro['id_residencia'];
			$query = "SELECT * FROM residencia WHERE id=$id";
	 		$resultado = mysqli_query($conexion, $query);
	 		$residencia=mysqli_fetch_assoc($resultado);
	  ?>
	  
	    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
	      <div class="card h-100">
		    <a href="residencia.php?id= <?php echo $id; ?>">
		      <img class="card-img-top" src="foto.php?id= <?php echo $id; ?>" alt="">
		    </a>
	        <div class="card-body">
		  	  <h4 class="card-title">
	            <a style="text-decoration: none;" href="residencia.php?id= <?php echo $id; ?>">
	              <?php echo $residencia['nombre']; ?>
	            </a>
	          </h4>
						
	          <div align="left"> 
					<?php	echo $residencia['descrip'];
					?> 
					<div align="right" >
						<br>
	          			<a  style="text-decoration: none;" class="btn-sm btn-info" href="residenciaReservada.php?id=<?php echo $id;?>">Más info</a>
					</div>
				</div>
				
			</div>		
	      </div>
	    </div>
	  <?php } ?>
	</div>
	
</div>
    
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
