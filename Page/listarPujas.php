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
    <title>HSH &mdash; Pujas</title>
    <meta charset="utf-8">
    <?php
      require('links.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   
    
  </head>
 <body style="background-image: url('images/hero_1.jpg');">

	<?php

        
	 	$queryPujas = "SELECT DISTINCT id_subasta FROM puja WHERE id_usuario = $idUser ";
		$resultadoPujas = mysqli_query($conexion, $queryPujas);
        
	?>
    <!-- Page Content -->
	<div class="container">
		<div class="py-2">
			<div class="row align-items-center text-center">
		      <div class="col-2">
	          	<a class="navbar-brand" href="index.php">
				    <img src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
				  </a>
	          </div>
				
			</div>
		<div class="col">
			<h1 style="color: white;" class='page-item' align ='center'>Mis Pujas</h1>
		</div>
		<br>
		<br>
	 	</div>

	  <div class="row">
      <?php
            while($puja = mysqli_fetch_assoc($resultadoPujas)){
				$id_subasta= $puja['id_subasta'];
				
				$resultadoMonto = mysqli_query($conexion,"SELECT monto FROM puja WHERE id_subasta = $id_subasta ORDER BY monto DESC LIMIT 1");
				$registroMonto = mysqli_fetch_assoc($resultadoMonto);
				
				$querySubastas = "SELECT * FROM subasta WHERE id = $id_subasta";
				$resultadoSubastas = mysqli_query($conexion, $querySubastas);

				while($registroSubasta = mysqli_fetch_assoc($resultadoSubastas)){
					
					$puja_ganadora = $registroSubasta['puja_ganadora'];
					$query_puja_ganadora = mysqli_query($conexion,"SELECT monto FROM puja WHERE id = $puja_ganadora ");
					$registroPujaGanadora = mysqli_fetch_assoc($query_puja_ganadora);
					
					$id_residencia = $registroSubasta['id_residencia'];
					
					$queryResidencia = "SELECT * FROM residencia WHERE id = $id_residencia";
					$resultadoResidencia = mysqli_query($conexion, $queryResidencia);
					$registroResidencia = mysqli_fetch_assoc($resultadoResidencia);
				?>

	            	<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
	                	<div class="card h-100">
		                	<a href="residencia.php?id= <?php echo $id_residencia; ?>">
		                    	<img class="card-img-top" src="foto.php?id= <?php echo $id_residencia; ?>" alt="">
			                </a>
		                	<div class="card-body">
			  	            	<h4 class="card-title">
	        	                	<a style="text-decoration: none;" href="residencia.php?id= <?php echo $id_residencia; ?>">
	            	            		<?php echo $registroResidencia['nombre']; ?>
	                	        	</a>
	                    		</h4>
						
		                    	<div align="left"> 
						        	<h4>Puja ganadora = $<?php echo ($registroPujaGanadora['monto']); ?></h4>
        	                    	<h4>Mi Puja =       $<?php echo ($registroMonto['monto']);?></h4>          
						       		<div align="right" >
							       		<br>
	          				       			<a  style="text-decoration: none;" class="btn-sm btn-info" href="residencia.php?id=<?php echo $id_residencia;?>">Más info</a>
					    	    	</div>
				        		</div>
				
				            </div>		
	           	    	</div>
	            	</div>
      <?php     }} 
            ?>
	</div>
	
</div>
    
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
