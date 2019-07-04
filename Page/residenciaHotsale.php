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
    $result = mysqli_query($conexion, $query);  //no toma la 2da consulta.
    $registro = mysqli_fetch_assoc($result);
    $queryPeriodos = "SELECT id_semana FROM hotsale WHERE id_residencia = $id";
    $resultSemanas = $conexion -> query($queryPeriodos);
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
          <p>Semanas en hotsale: </p>
            <select name="periodo" form="subastaForm" required>
            <?php
                foreach($resultSemanas as $idPeriodo) {
                $queryFecha = "SELECT num_semana, anio FROM semana WHERE id= $idPeriodo";
                $resFecha = $conexion -> query($queryPeriodos);
                if($resFecha->num_rows > 0) {
                    $fila = mysqli_fetch_assoc($resFecha);
                    $semana = $fila['num_semana'];
                    $anio = $fila['anio'];
                    $j= $semana * 7;
                    $date= strtotime("+ $j day");
                    $fecha = date('y-m-d',$date);
                    echo('<option value='.$fecha.'>'."Semana del ".date("d/m", strtotime($fecha))." del año ".($anio).'</option>');
                }
                }
            ?>
            </select>
            <p></p>
          <button class="btn btn-primary" onclick="goBack()">Atras</button>
          <a class="btn btn-primary">Comprar</a>
        </div>
      </div>
      <!-- /.row -->


    </div>
</div>    
<!-- /.container -->
<script>
  function goBack() {
    window.history.back();
  }
  </script>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
