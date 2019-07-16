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
		$id = $_GET['idResi'];
    $idHotsale = $_GET['idHotsale'];
    $idSemana = $_GET['idSemana'];
    $query = "SELECT * FROM residencia WHERE id=$id";
    $result = mysqli_query($conexion, $query); 
    $registro = mysqli_fetch_assoc($result);
    $queryHotsale = "SELECT * FROM hotsale WHERE id=$idHotsale";
    $resultHotsale = mysqli_query($conexion, $queryHotsale); 
    $registroHotsale = mysqli_fetch_assoc($resultHotsale);
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
		  
          <p>Descripción:
			    <?php echo $registro['descrip']; ?>
          </p>
          <p>Dirección:
          <?php echo $registro['direccion']; ?>
          </p>
          <p>Capacidad:
			    <?php echo $registro['capacidad']; ?> personas
          </p>
          <p><b>Precio: $
			    <?php echo $registroHotsale['precio']; ?>
          </b></p>
          <?php 
          $semanaQuery="SELECT * FROM semana WHERE id = $idSemana";
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

          echo "<p>Semana del hotsale: 
                <i style='font-size:14px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                </br>
         
          <button style='background-color: #15B5FF; color:white; border-color: white;' class='btn btn-info' onclick='goBack()'>Atras</button>
          <a href='comprarHotsale.php?idResi=$id&idHotsale=$idHotsale&idSemana=$idSemana' style='background-color: #15B5FF; color:white; border-color: white;' class='btn btn-primary'>Comprar</a>
        </div>
      </div>
    </div>
</div>";  ?>  

<script>
  function goBack() {
    window.history.back();
  }
  </script>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
