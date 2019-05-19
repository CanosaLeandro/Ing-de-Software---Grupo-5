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
   
    
  </head>

 <body>
	<?php
		$id = $_GET['id'];
		$query = "SELECT * FROM residencia WHERE id=$id";
		$result = mysqli_query($conexion, $query);
		$registro = mysqli_fetch_assoc($result);
	?>
		
	<!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4">
		<?php
			echo $registro['nombre'];
		?>
        <small>
        <?php
			echo $registro['ubicacion'];
		?>
        </small>
      </h1>

      <!-- Project One -->
      <div class="row">
        <div class="col-md-7">
          <a href="#">
            <img class="img-fluid rounded mb-3 mb-md-0" 
            src="foto.php?id= <?php echo $id; ?>"
            alt="">
          </a>
        </div>
        <div class="col-md-5">
          <p>
			<?php echo $registro['descrip']; ?>
          </p>
          <br>
          <p> 
			<?php echo $registro['capacidad']; ?>
          </p>
          <a class="btn btn-primary" href="#">Volver atras</a>
          
          <a class="btn btn-primary" href="#">Reservar</a>
        </div>
      </div>
      <!-- /.row -->


    </div>
    <!-- /.container -->


  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
