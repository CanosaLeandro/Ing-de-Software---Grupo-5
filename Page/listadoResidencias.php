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

	$id = $_SESSION['id'];
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
 <body>
<!-- Page Content -->
<!--<div class="container">
   Muestra de residencias -->
	<?php
		//cantidad de registros por pagina
		$por_pagina = 30;
	
		//si se presiono algun indice de la paginacion
		if(isset($_GET['pagina'])){
			$pagina = $_GET['pagina'];
		}else{
			$pagina = 1;
		}
	
		//la pagina inicia en 0 y se multiplica por $por_pagina
	
		$empieza = ($pagina - 1) * $por_pagina;
	
	 	$query = "SELECT * FROM residencia WHERE activo = 'si' ORDER BY ubicacion LIMIT $empieza, $por_pagina";
	 	$resultado = mysqli_query($conexion, $query);
	 	
	?>
    <!-- Page Content -->
	<div class="container">
		<div class="py-2">
			<div class="row align-items-center text-center">
	      <div class="col-2">
          	<a class="navbar-brand" href="index.php">
			    <img style="margin-top: -50px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
			  </a>
         </div>
	  <!-- Page Heading -->
				<div class="col-8">
    			<h1 class='page-item' align ='center'> Nuestras propiedades</h1>
				</div>
				</div>
	 		</div>

	  <div class="row">
	  <?php
		while($registro = mysqli_fetch_assoc($resultado)){
			$id = $registro['id'];
	  ?>
	  
	    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
	      <div class="card h-100">
		    <a href="residencia.php?id= <?php echo $id; ?>">
		      <img class="card-img-top" src="foto.php?id= <?php echo $id; ?>" alt="">
		    </a>
	        <div class="card-body">
		  	  <h4 class="card-title">
	            <a style="text-decoration: none;" href="residencia.php?id= <?php echo $id; ?>">
	              <?php echo $registro['nombre']; ?>
	            </a>
	          </h4>
						
	          <div align="left"> 
					<?php	echo $registro['descrip'];
					?> 
	  						
					<div align="right" >
	          		<a  style="text-decoration: none;" class="btn-sm btn-primary " href="residencia.php?id=<?php echo $id; ?>">Más info</a>
								<?php
          			if ($registro['en_hotsale']=='si'){?>
         	  	 	<p></p>
							<a style="text-decoration: none;" class="btn-sm btn-primary" href="residenciaHotsale.php?id=<?php echo $id; ?>">Ver Hotsale</a>
						
					<?php }
          			if ($registro['en_subasta']=='si'){?>
          	 	 		<a style="text-decoration: none;" class="btn-sm btn-primary" href="subasta.php?id=<?php echo $id; ?>">Ver Subasta</a>
          	 	 	<?php }?>
          	 	 	
					</div>
				</div>
				
			</div>		
	      </div>
	    </div>
	  <?php } ?>
	</div>
	<!-- /.row -->
	
	<?php
		$qry="SELECT * FROM residencia WHERE activo = 'si' ORDER BY ubicacion ASC ";
	
		$result = mysqli_query($conexion, $qry);
		//contar el total de registros
		$total_registros = mysqli_num_rows($result);
	?>
	<div class="clearfix">
	<?php
		if(isset($total_registros)) {
			$total_paginas= 1;
			if($total_registros>$por_pagina){
				$j = $por_pagina;
				//usando ceil para dividir el total de registros entre $por_pagina
				//ceil redondea un numero para abajo
				$total_paginas = ceil($total_registros / $por_pagina);
			}
			else
				$j = $total_registros;
	?>
    <div class="hint-text text-right">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros;?></b> residencias</div>
    <ul class="pagination">
	<?php
		//link a la primera pagina

		for($i=1; $i < $total_paginas; $i++){ 
				echo "<li class='page-item'>
						<a href='index.php?pagina=".$i."' class='page-link'>".$i."</a>
					  </li>";
		}
		

	 //link a la ultima pagina
   if($total_registros>$por_pagina){
    echo "<li class='page-item' ><a href='index.php?pagina=$total_paginas' class='page-link'>".'Ultimos registros'."</a></li>";
    }
	?>
	</ul>
	
	<?php 
	} ?>
	</div>
</div>
	<!-- /.container -->
    
    <footer class="site-footer">
			<div id="footer" class="container">
				<div class="row text-center">
					<div class="col-md-12">
						<h3 class="footer-heading mb-4 text-white">About</h3>
						<p>Home Switch Home. Calidad y confort.</p>
						<!-- <p><a href="#" class="btn btn-primary pill text-white px-4">Read More</a></p> -->
					</div>
				</div>
				<div class="row text-center">
					<div class="col-md-12">
						<p>
							Canosa Leandro Joaquin, Pugliese Alejo Ezequiel, Tomiello Matias.
						</p>
					</div>
				</div>
			</div>
		</footer>

  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
