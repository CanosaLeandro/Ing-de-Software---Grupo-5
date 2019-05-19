<!DOCTYPE html>
<html lang="en">
	<?php Include("DB.php"); $conexion = conectar(); ?>
  <head>
    <title>HSH &mdash; Inicio</title>
    <meta charset="utf-8">
    <?php
		require('links.php');
    ?>
    
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
                <h2 class="mb-0 site-logo"><a href="index.php">HSH</a></h2>
              </div>
              <div class="col-10">
                <nav class="site-navigation text-right" role="navigation">
                  <div class="container">
                    
                    <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                      <li class="active">
                        <a href="index.php">Home</a>
                      </li>
                      <li class="has-children">
                        <a href="rooms.php">Buscar Residencias</a>
                        <ul class="dropdown arrow-top">
                          <li><a href="rooms.php">Buscar por ubicacion</a></li>
                          <li><a href="rooms.php">Buscar por descripción</a></li>
                          <li><a href="rooms.php">Buscar por subastas</a></li>
                          <!-- <li class="has-children">
                            <a href="rooms.php">Rooms</a>
                            <ul class="dropdown">
                              <li><a href="rooms.php">America</a></li>
                              <li><a href="rooms.php">Europe</a></li>
                              <li><a href="rooms.php">Asia</a></li>
                              <li><a href="rooms.php">Africa</a></li>
                              
                            </ul>
                          </li> -->

                        </ul>
                      </li>
                      <li><a href="hotsales.php">Hotsale</a></li>
                      <li><a href="subastas.php">Subastas</a></li>
                      <li><a href="contact.php">Contacto</a></li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
    
    <div class="slide-one-item home-slider owl-carousel">
      
      <div class="site-blocks-cover overlay" style="background-image: url(images/hero_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              
              <h1 class="mb-2">Bienvenido a Home Switch Home</h1>
              <h2 class="caption">Lujo &amp; Comodidad</h2>
            </div>
          </div>
        </div>
      </div>  

      <div class="site-blocks-cover overlay" style="background-image: url(images/hero_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1 class="mb-2">Subastas</h1>
              <h2 class="caption">Participa de nuestras subastas</h2>
            </div>
          </div>
        </div>
      </div> 

      <div class="site-blocks-cover overlay" style="background-image: url(images/hero_3.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7 text-center" data-aos="fade">
              <h1 class="mb-2">Ofertas en Hotsale</h1>
              <h2 class="caption">Aprobecha las mejores ofertas</h2>
            </div>
          </div>
        </div>
      </div> 

    </div>
	
	<!-- Muestra de residencias -->
	<?php
		//cantidad de registros por pagina
		$por_pagina = 2;
	
		//si se presiono algun indice de la paginacion
		if(isset($_GET['pagina'])){
			$pagina = $_GET['pagina'];
		}else{
			$pagina = 1;
		}
	
		//la pagina inicia en 0 y se multiplica por $por_pagina
	
		$empieza = ($pagina - 1) * $por_pagina;
	
	 	$query = "SELECT * FROM residencia ORDER BY ubicacion LIMIT $empieza, $por_pagina";
	 	$resultado = mysqli_query($conexion, $query);
	?>
    <!-- Page Content -->
	<div class="container">
	
	  <!-- Page Heading -->
	  <h1 class="my-4">Nuestras residencias
	  </h1>
	  
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
	            <a href="residencia.php?id= <?php echo $id; ?>">
	              <?php echo $registro['nombre']; ?>
	            </a>
	          </h4>
	          <p class="card-text"> 
			    <?php echo $registro['descrip']; ?> 
			  </p>
	          <a class="btn btn-primary" href="residencia.php?id= <?php echo $id; ?>">Más info</a>
	        </div>
	      </div>
	    </div>
	  <?php } ?>
	</div>
	<!-- /.row -->
	
	<?php
            $qry="SELECT * FROM residencia ORDER BY ubicacion ASC";
	
				$result = mysqli_query($conexion, $qry);
				//contar el total de registros
				$total_registros = mysqli_num_rows($result);
			?>
			<div class="clearfix">
				<?php
				if(isset($total_registros)) {

				if($total_registros>5) {

					//usando ceil para dividir el total de registros entre $por_pagina
				    //ceil redondea un numero para abajo
					$total_paginas = ceil($total_registros / $por_pagina);

				?>
                <div class="hint-text">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros;?></b> registros</div>
                <ul class="pagination">
                	
                <?php
					//link a la primera pagina
                    echo "<li class='page-item'><a href='index.php?pagina=1'>".'Primeros registros'."</a></li>";


					for($i=2; $i < $total_paginas-1; $i++){ 
							echo "<li class='page-item'><a href='index.php?pagina=".$i."' class='page-link'>".$i."</a></li>";
					}

                    //link a la ultima pagina
				    echo "<li class='page-item'><a href='index.php?pagina=$total_paginas' class='page-link'>".'Ultimos registros'."</a></li>";

				}}
		?>
	</div>
	<!-- /.container -->
    
    <footer class="site-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<h3 class="footer-heading mb-4 text-white">About</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat quos rem ullam, placeat amet.</p>
						<p><a href="#" class="btn btn-primary pill text-white px-4">Read More</a></p>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<h3 class="footer-heading mb-4 text-white">Quick Menu</h3>
								<ul class="list-unstyled">
									<li><a href="#">About</a></li>
									<li><a href="#">Services</a></li>
									<li><a href="#">Approach</a></li>
									<li><a href="#">Sustainability</a></li>
									<li><a href="#">News</a></li>
									<li><a href="#">Careers</a></li>
								</ul>
							</div>
						<div class="col-md-6">
							<h3 class="footer-heading mb-4 text-white">Ministries</h3>
							<ul class="list-unstyled">
								<li><a href="#">Children</a></li>
								<li><a href="#">Women</a></li>
								<li><a href="#">Bible Study</a></li>
								<li><a href="#">Church</a></li>
								<li><a href="#">Missionaries</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="col-md-12"><h3 class="footer-heading mb-4 text-white">Social Icons</h3></div>
						<div class="col-md-12">
							<p>
								<a href="#" class="pb-2 pr-2 pl-0"><span class="icon-facebook"></span></a>
								<a href="#" class="p-2"><span class="icon-twitter"></span></a>
								<a href="#" class="p-2"><span class="icon-instagram"></span></a>
								<a href="#" class="p-2"><span class="icon-vimeo"></span></a>
							</p>
						</div>
					</div>
				</div>
				<div class="row pt-5 mt-5 text-center">
					<div class="col-md-12">
						<p>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy; <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All Rights Reserved | This template is made with <i class="icon-heart text-primary" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
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

  </body>
</html>
