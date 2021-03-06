<!DOCTYPE html>
<html lang="en">
  <?php 
  Include("DB.php");
  Include("calcularCreditos.php"); 
	$conexion = conectar(); 

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
  ?>
  <head>
    <title>HSH &mdash; Residencia</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/vertical-jumbotron.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
  </head>

 <body>
	<?php
		$id = $_GET['id'];
		$query = "SELECT * FROM residencia WHERE id=$id";
		$result = mysqli_query($conexion, $query);
		$registro = mysqli_fetch_assoc($result);

    $idUsuario=$_SESSION['id'];
    $infoUsuario=mysqli_query($conexion,"SELECT * FROM usuario WHERE id = $idUsuario");
    $usuario=mysqli_fetch_assoc($infoUsuario);
	?>
		
	<!-- Page Content -->
<div class="container">
  <div class="py-2">
      <div class="row align-items-center text-center">
        <div class="col-2">
            <a class="navbar-brand" href="index.php">
              <img style="margin-top: -35px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
            </a>
        </div>
      </div>
  </div>
	<div class="jumbotron vertical-center">

      <!-- Page Heading -->
      <h2 class="display-4" align="center">
		<?php
			echo $registro['nombre'];
		?>
		<br>
        <small>
        <?php
			echo $registro['ubicacion'];
		?>
        </small>
      </h2>
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
        <p>Direccion:
			    <?php echo $registro['direccion']; ?>
          </p>
          <p>Descripcion:
			<?php echo $registro['descrip']; ?>
          </p>
          <br>
          <p>
			Capacidad:
			<?php echo $registro['capacidad']; ?>
          </p>
          <button class="btn btn-info" onclick="goBack()">Atras</button>
          <?php 
          $anio = date('Y',strtotime(date('Y-m-d')."+ 6 months"));
          $creditosAñoIncio= calcularCreditos($idUsuario, $anio);
          $anioFin = date('Y',strtotime(date('Y-m-d')."+ 12 months"));
          $creditosAñoFin= calcularCreditos($idUsuario, $anioFin);
          if (($usuario['suscripto']=='si')&&(($creditosAñoIncio>0)||($creditosAñoFin>0))){?>
            <a style="text-decoration: none;" class="btn btn-primary" href="reservar.php?id=<?php echo $id; ?>">Reservar</a>
          <?php }
          ?>
          <?php /*
          if ($registro['en_hotsale']=='si'){?>
            <a class="btn btn-primary" href="residenciaHotsale.php?id=<?php echo $id; ?>">Ver Hotsale</a>
          <?php }*/?><!---
          if ($registro['en_subasta']=='si'){?>
            <a class="btn btn-primary" href="subasta.php?id=<?php echo $id; ?>">Ver Subasta</a>
          <?php /*}*/
          ?> -->
        </div>
      </div>
      <!-- /.row -->


    </div>
</div>    
<!-- /.container -->
  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>
  <script>
  function goBack() {
    window.history.back();
  }
  </script>

  </body>
</html>
