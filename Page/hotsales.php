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

	$idUser = $_SESSION['id'];

	$resultadoActualizar = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = $idUser");
	$registroActualizar = mysqli_fetch_assoc($resultadoActualizar);

	?>
  <head>
    <title>HSH &mdash; Inicio</title>
    <meta charset="utf-8">
    <?php
      require('links.php');
    ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
  </head>
  <body>  
  
  <!-- menu cabecera -->
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    <div class="site-navbar-wrap js-site-navbar bg-white">
      
      <div class="container">
        <div class="site-navbar bg-light">
          <div class="py-1">
            <div class="row align-items-center">
              <div class="col-2">
              	<a class="navbar-brand" href="index.php">
				    <img style="margin-top: -50px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
				  </a>
              </div>
              <div class="col-10">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container-fluit">
                    
                    <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                       <li>
                    	<?php if(($registroActualizar['suscripto'] == 'no') and ($registroActualizar['actualizar'] == 'no')){
                    		echo "<button id='btn-suscribirse' class='btn btn-primary'><a style='color: white;' href='suscribirse.php'>".'Suscribirse'."</a></button>";
                    		}
                    	 ?>
                    	</li>
						<li class="has-children">
                        <a >Buscar Residencias</a>
                        <ul class="dropdown arrow-top">
                          <li><a href="buscarDescripcion.php">Buscar por descripción</a></li>
                          <li><a href="buscarHotsale.php">Buscar por hotsale</a></li>
                          <li><a href="buscar.php">Buscar por subastas</a></li>
                          <li><a href="buscarSemanas.php">Buscar por semanas</a></li>
                          <li><a href="buscarUbicacion.php">Buscar por ubicacion</a></li>
                        </ul>
                      </li>
                      <li><a href="hotsales.php">Hotsale</a></li>
                      <li><a href="subastas.php">Subastas</a></li>
					  <li>
					  	<div>
						  <a href="" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						  <b> Mi HSH </b>
						  </a>
						  <div style="cursor: pointer; width: 10%;" class="dropdown-menu" aria-labelledby="dropdownMenu2">
							<a href="verPerfil.php" class="dropdown-item enlaceEditar">Ver mi perfil</a>
							<a href="listaReservas.php" class="dropdown-item enlaceEditar">Reservas realizadas</a>
						    <a href="listarPujas.php" class="dropdown-item enlaceEditar">Ver mis pujas</a>
							<a href="listarHotsales.php" class="dropdown-item enlaceEditar">Ver mis hotsales</a>
							<a href="editModalUser.php" class="dropdown-item enlaceEditar">Editar cuenta</a>
							<a href="deleteUser.php?id=<?php echo $id; ?>" class="dropdown-item enlaceEditar">Borrar cuenta</a>
						    <div class="dropdown-divider"></div>
						    <a href="logout.php" class="dropdown-item enlaceEditar" >Cerrar sesión</a>
						  </div>
						</div>
					  </li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
    

      <?php 
      	if (($registroActualizar['suscripto'] == 'si') and ($registroActualizar['actualizar'] == 'no')) {
      		header("Location: infoSuscribirse.php");
		}
       ?>
  
      <div class="site-blocks-cover overlay" style="background-image: url(images/hero_3.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1 class="mb-2">Ofertas en Hotsale</h1>
              <h2 class="caption">Aprovecha las mejores ofertas</h2>
            </div>
          </div>
        </div>
      </div> 


	
	<!-- Muestra de residencias -->
	<?php
		//cantidad de registros por pagina
		$por_pagina = 4;
	
		//si se presiono algun indice de la paginacion
		if(isset($_GET['pagina'])){
			$pagina = $_GET['pagina'];
		}else{
			$pagina = 1;
		}
	
		//la pagina inicia en 0 y se multiplica por $por_pagina
		$empieza = ($pagina - 1) * $por_pagina;
		$query = "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, h.precio, h.id_semana, r.id AS idResi, h.id AS idHotsale 
                FROM residencia r
                INNER JOIN hotsale h ON r.id = h.id_residencia
                WHERE r.activo='si' AND h.activo='si'
                ORDER BY r.id LIMIT $empieza, $por_pagina";
	 	$resultado = mysqli_query($conexion, $query);

	?>
    <!-- Page Content -->
<div class="container"> 
	  <!-- Page Heading -->
    <p></p>
		<h1 style='color: #31AEF5;' align ='center' class='page-item'>Nuestros Hotsales
	  </h1>
	  
	<div class="row">
	  
	<?php
	while($registro = mysqli_fetch_assoc($resultado)){
	    $id=$registro['idResi'];
	    $idHotsale=$registro['idHotsale'];

		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$zonahoraria = date_default_timezone_get();
		@$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As.

		//dia,mes y año actual
		$diaFechaAct = substr($fecha_actual, 8,2);
		$mesFechaAct = substr($fecha_actual, 5, 2); 
		$anioFechaAct = substr($fecha_actual, 0, 4);

		$idPeriodo=$registro['id_semana'];
		$semanaQuery="SELECT * FROM semana WHERE id = $idPeriodo";
		$resultadoSemana=mysqli_query($conexion,$semanaQuery);

		$registroSemana=mysqli_fetch_assoc($resultadoSemana);
		$week=$registroSemana['num_semana'];
		$anio=$registroSemana['anio'];

		for($i=0; $i<7; $i++){
			if ($i == 0) {
			    $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anio));
			}
			if ($i == 6) {
			     $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anio));
			}
		}

		//datos del inicio del hotsale
		$diaInicia = substr($inicia, 0,2);
		$mesInicia = substr($inicia, 3, 2); 
		$anioInicia = substr($inicia, 6, 4);

		$diaTermina = substr($termina, 0,2);
		$mesTermina = substr($termina, 3, 2);
		$anioTermina = substr($termina, 6, 4);

		//si el hotsale ya empezo, entonces no se muestra

		//aca chequeo si empezo y no termino la subasta
		if ($anioFechaAct == $anioInicia) {//tienen el mismo año

		    //si el año es igual, hay que chequear el mes
		    if ($mesFechaAct == $mesInicia) {//tienen el mismo mes

		        //chequeo que la fecha actual no supere al dia de inicio
		        if ($diaFechaAct<$diaInicia) {
		        //entonces se muestra la info del hotsale
	            	echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
				      <div class='card h-100'>
					    <a href='residencia.php?id=$id'>
					      <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
					    </a>
				        <div class='card-body'>
					  	  <h4 class='card-title'>
				            <a style='text-decoration: none;' href='residencia.php?id=$id'>
				              ".$registro['nombre']."
				            </a>
				          </h4>
	                  	  <p>Semana del hotsale<br>
	                  	  <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anioTermina."</i></p>
	                  	  </br>
				          <a class='btn btn-info' href='residenciaHotsale.php?idResi=$id&idHotsale=$idHotsale&idSemana=$idPeriodo'>Ver Hotsale</a>
				        </div>
				      </div>
				    </div>";
		            
		        }   
		    } 
		    elseif ($mesFechaAct<$mesInicia) {
		     	echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
				      <div class='card h-100'>
					    <a href='residencia.php?id=$id'>
					      <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
					    </a>
				        <div class='card-body'>
					  	  <h4 class='card-title'>
				            <a style='text-decoration: none;' href='residencia.php?id=$id'>
				              ".$registro['nombre']."
				            </a>
				          </h4>
	                  	  <p>Semana del hotsale<br>
	                  	  <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anioTermina."</i></p>
	                  	  </br>
				          <a class='btn btn-info' href='residenciaHotsale.php?idResi=$id&idHotsale=$idHotsale&idSemana=$idPeriodo'>Ver Hotsale</a>
				        </div>
				      </div>
				    </div>";
		    } 
		}
		//aca chequeo la fecha actual no supero el dia de inicio del hotsale
		elseif($anioFechaAct < $anioInicia){//el hotsale no comenzo todavia
		      //se muestra la info del hotsale
		      echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
				      <div class='card h-100'>
					    <a href='residencia.php?id=$id'>
					      <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
					    </a>
				        <div class='card-body'>
					  	  <h4 class='card-title'>
				            <a style='text-decoration: none;' href='residencia.php?id=$id'>
				              ".$registro['nombre']."
				            </a>
				          </h4>
		              <p>Semana del hotsale</br>
		              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anioTermina."</i></p> 
		              <br>
		              <a class='btn btn-info' href='residenciaHotsale.php?idResi=$id&idHotsale=$idHotsale&idSemana=$idPeriodo'>Ver Hotsale</a>
		            </div>
			      </div>
			    </div>";
		}
	}
	echo "</div>";
	$qry = "SELECT * 
            FROM residencia r
            INNER JOIN hotsale h ON r.id = h.id_residencia 
            WHERE r.activo='si' AND h.activo='si'";

	$result = mysqli_query($conexion, $qry);
	//contar el total de registros
	$total_registros = mysqli_num_rows($result);
	?>
	<div class="clearfix">
	<?php
	if(isset($total_registros)) {
		if($total_registros>0) {
			$total_paginas= 1;
			if($total_registros>4){
				$j = 4;
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
						<a href='hotsales.php?pagina=".$i."' class='page-link'>".$i."</a>
					  </li>";
		}
		

	 //link a la ultima pagina
   if($total_registros>4){
    echo "<li class='page-item' ><a href='hotsales.php?pagina=$total_paginas' class='page-link'>".'Ultimos registros'."</a></li>";
    }
	?>
	</ul>
	
  <?php
 	}else{
 		echo "<h4 style='color:red;' align='center'>No hay hotsale disponibles actualmente.</h4>";
 	}
} ?>
	</div>
</div>
	<!-- /.container -->
    
    <footer class="site-footer">
			<div class="container">
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
    
  </div>

	  <script src="js/jquery-3.3.1.min.js"></script>
	  <script src="js/jquery-migrate-3.0.1.min.js"></script>
	  <script src="js/jquery-ui.js"></script>
	  <script src="js/popper.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/owl.carousel.min.js"></script>
	  <script src="js/jquery.stellar.min.js"></script>
	  <script src="js/jquery.countdown.min.js"></script>
	  <script src="js/jquery.magnific-popup.min.js"></script>
	  <script src="js/bootstrap-datepicker.min.js"></script>
	  <script src="js/aos.js"></script>

  
  <script src="js/mediaelement-and-player.min.js"></script>

  <script src="js/main.js"></script>
    

  <script>
      document.addEventListener('DOMContentLoaded', function() {
                var mediaElements = document.querySelectorAll('video, audio'), total = mediaElements.length;

                for (var i = 0; i < total; i++) {
                    new MediaElementPlayer(mediaElements[i], {
                        pluginPath: 'https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/',
                        shimScriptAccess: 'always',
                        success: function () {
                            var target = document.body.querySelectorAll('.player'), targetTotal = target.length;
                            for (var j = 0; j < targetTotal; j++) {
                                target[j].style.visibility = 'visible';
                            }
                  }
                });
                }
            });
    </script>
</html>