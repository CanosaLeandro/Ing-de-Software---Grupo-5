<!DOCTYPE html>
<html lang="en">
  <?php 
	Include("DB.php"); 
	$conexion = conectar(); 
  ?>
  <head>
    <title>HSH &mdash; Residencia</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/vertical-jumbotron.css">
    
  </head>

 <body>
	<?php
		$id = $_GET['id'];
        $query = "SELECT * FROM residencia WHERE id=$id and en_hotsale= 'si' ";
        $qwert = "SELECT * FROM hotsale WHERE id=$id";
        $resultado = mysqli_query($conexion, $qwert);
        $reg = mysqli_fetch_assoc($resultado);
		$result = mysqli_query($conexion, $query);  //no toma la 2da consulta.
		$registro = mysqli_fetch_assoc($result);
	?>
		
	<!-- Page Content -->
<div class="container">
	<div class="jumbotron vertical-center">

      <!-- Page Heading -->
      <h1 class="display-4" align="center">
		<?php
			echo $registro['nombre'];
		?>
		<br>
        <small>
        <?php
			echo $registro['ubicacion'];
		?>
        </small>
      </h1>
	  <hr>
      <!-- Project One -->
      <div class="row">
        <div class="col-md-5">
          <a>
            <img class="img-fluid rounded mb-3 mb-md-0" 
            src="foto.php?id= <?php echo $id; ?>"
            alt="">
          </a>
        </div>
        <div class="col-md-7">
		  
          <p>Descripcion:
			<?php echo $registro['descrip']; ?>
          </p>
          <p>Capacidad:
			<?php echo $registro['capacidad']; ?>
          </p>
          <p>Fecha:
			<?php echo $reg['fecha']; ?>
          </p>
          <p>Precio:
			<?php echo $reg['precio']; ?>
          </p>
          <a class="btn btn-primary" href="hotsales.php">Volver atras</a>
          <a class="btn btn-primary" href="#">Comprar</a>
        </div>
      </div>
      <!-- /.row -->


    </div>
</div>    
<!-- /.container -->
  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
