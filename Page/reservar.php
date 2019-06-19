<!DOCTYPE html>
<html lang="en">
  <?php 
	Include("DB.php"); 
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
		$id = $_GET['id'];//id de la residencia
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
          <br>
          <p>
			Capacidad:
			<?php echo $registro['capacidad']; ?>
          </p>

          <?php 
          date_default_timezone_set('America/Argentina/Buenos_Aires');
            $zonahoraria = date_default_timezone_get();
            @$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 
           

            #separas la fecha en subcadenas y asignarlas a variables
            #relacionadas en contenido, por ejemplo dia, mes y anio.

            $dia   = substr($fecha_actual,8,2);
            $mes = substr($fecha_actual,5,2);
            $anio = substr($fecha_actual,0,4);

            $semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));  
            //donde:
                    
            #W (mayúscula) te devuelve el número de semana
            #w (minúscula) te devuelve el número de día dentro de la semana (0=domingo, #6=sabado)

          ?>

        <form method="POST" action="realizarReserva.php">
          <div class="form-group">
            <input type="hidden" name="idResidencia" value=<?php echo $id;?>>
            <label for="exampleFormControlSelect1">Elegir una semana para reservar</label>
            <select class="form-control" id="exampleFormControlSelect1" name="semana" value="">
              <?php 
              @$anioActual=date("Y");
              $querySemanas = "SELECT * FROM periodo WHERE id_residencia='$id' AND activa='si' AND anio='$anioActual'";
              $semanas = mysqli_query($conexion, $querySemanas);
              while ($row = mysqli_fetch_assoc($semanas)) {
                //se muestran las semanas disponibles
                $week = $row['semana'];
                for($i=0; $i<7; $i++){
                  if ($i == 0) {
                      $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day')) . '<br />';
                  }
                  if ($i == 6) {
                       $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day')) . '<br />';
                  }
                }
                if ($semana <= $week){
                                 
                  echo '<option class="" value='.$row["semana"].'>Comienza el día '.$inicia.' y termina el día '.$termina.'</option>';

                } }; ?>
            </select>
            <br>
            <a style="color: white;" class="btn btn-primary" onclick="goBack()">Atras</a>
            <?php 
            if (($usuario['suscripto']=='si')&&($usuario['creditos']>0)){?>
              <button type="submit" class="btn btn-primary">Reservar</button>
            <?php }
            ?>
          </div>
        </form>
        </div>
      </div>
    </div>
</div>    
  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>
  <script>
  function goBack() {
    window.history.back();
  }
  </script>

  </body>
</html>
