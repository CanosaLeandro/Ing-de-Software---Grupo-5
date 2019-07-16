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
  $authentication->logueadoAdmin();
}catch(Exception $ex){
  $error = $ex->getMessage();
  echo "<script>alert('$error');</script>";
  echo "<script>window.location = 'loginAdmin.php';</script>";
}
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
	?>
		
<div class="container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="crearHotsale.php">
      <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
      Home Switch Home
    </a>
    <a class="navbar-brand" href="crudUsuarios.php">Usuarios</a>
    <div style="margin-left: 45%;" class="d-flex align-items-end">
      <div class="ml-5 p-2">
        <a href="logoutAdmin.php" type="button" class="btn btn-danger btn-sm">Cerrar sesión</a> 
      </div>
    </div>     
  </nav>
	<div class="jumbotron vertical-center">

    <h2 class="display-4" align="center">
      Crear Hotsale
    <br>
        <small>
          Formulario
        </small>
    </h2>
	  


          <?php 
          date_default_timezone_set('America/Argentina/Buenos_Aires');
            $zonahoraria = date_default_timezone_get();
            @$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 

            $diaActual = substr($fecha_actual,8,2);
            $mesActual = substr($fecha_actual,5,2);
            $anioActual = substr($fecha_actual,0,4);

            //PARA EL DIA DE FECHA DE INICIO
            switch ($diaActual) {
                case '01':
                    $diaActual=1;
                    break;
                case '02':
                    $diaActual=2;
                    break;
                case '03':
                    $diaActual=3;
                    break;
                case '04':
                    $diaActual=4;
                    break;
                case '05':
                    $diaActual=5;
                    break;
                case '06':
                    $diaActual=6;
                    break;
                case '07':
                    $diaActual=7;
                    break;
                case '08':
                    $diaActual=8;
                    break;
                case '09':
                    $diaActual=9;
                    break;
            }

            //PARA EL MES DE FECHA DE INICIO
            switch ($mesActual) {
                case '01':
                    $mesActual=1;
                    break;
                case '02':
                    $mesActual=2;
                    break;
                case '03':
                    $mesActual=3;
                    break;
                case '04':
                    $mesActual=4;
                    break;
                case '05':
                    $mesActual=5;
                    break;
                case '06':
                    $mesActual=6;
                    break;
                case '07':
                    $mesActual=7;
                    break;
                case '08':
                    $mesActual=8;
                    break;
                case '09':
                    $mesActual=9;
                    break;
            }

            $semanaActual = date('W',  mktime(0,0,0,$mesActual,$diaActual,$anioActual)); 
           
            $fechaAux = date("Y-m-d",strtotime($fecha_actual."+ 6 months"));

            $diaTermina   = substr($fechaAux,8,2);
            $mesTermina = substr($fechaAux,5,2);
            $anioTermina = substr($fechaAux,0,4);

            //PARA EL DIA DE FECHA DE FIN
            switch ($diaTermina) {
                case '01':
                    $diaTermina=1;
                    break;
                case '02':
                    $diaTermina=2;
                    break;
                case '03':
                    $diaTermina=3;
                    break;
                case '04':
                    $diaTermina=4;
                    break;
                case '05':
                    $diaTermina=5;
                    break;
                case '06':
                    $diaTermina=6;
                    break;
                case '07':
                    $diaTermina=7;
                    break;
                case '08':
                    $diaTermina=8;
                    break;
                case '09':
                    $diaTermina=9;
                    break;
            }

            //PARA EL MES DE FECHA DE FIN
            switch ($mesTermina) {
                case '01':
                    $mesTermina=1;
                    break;
                case '02':
                    $mesTermina=2;
                    break;
                case '03':
                    $mesTermina=3;
                    break;
                case '04':
                    $mesTermina=4;
                    break;
                case '05':
                    $mesTermina=5;
                    break;
                case '06':
                    $mesTermina=6;
                    break;
                case '07':
                    $mesTermina=7;
                    break;
                case '08':
                    $mesTermina=8;
                    break;
                case '09':
                    $mesTermina=9;
                    break;
            }
            $semanaTermina = date('W',  mktime(0,0,0,$mesTermina,$diaTermina,$anioTermina));
          ?>
      <div class="row">
        <form method="POST" action="addHotsale.php">
          <div class="form-group mx-sm-3 mb-2">
            <input type="hidden" name="idResidencia" value=<?php echo $id;?>>
             <?php 
            echo"
            <label for='precio'>Precio del Hotsale </label> 
            <div class='col-8'>
              <input type='number' class='form-control' id='precio' name='precio' min=1 required>
            </div>
            <br>
            <label for='exampleFormControlSelect1'>Elegir una semana para reservar</label>
            <div class='col-12'>";
            
            if ($semanaActual>$semanaTermina) {//termina en el otro año ?>
            <select class="form-control" id="exampleFormControlSelect1" name="semana" value="">
              <?php 
                $querySemanasDelAnio = "SELECT * FROM semana WHERE ((id_residencia=$id) AND (disponible='si') AND (num_semana BETWEEN $semanaActual AND 52) AND (anio=$anioActual))";
                $querySemanasDelAnioSiguiente = "SELECT * FROM semana WHERE ((id_residencia=$id) AND (disponible='si') AND (num_semana BETWEEN 1 AND $semanaTermina) AND (anio=$anioTermina))";

                $semanas = mysqli_query($conexion, $querySemanasDelAnio);
                while ($row = mysqli_fetch_assoc($semanas)) {
                //se muestran las semanas disponibles
                    $idPeriodo=$row['id'];
                    $week = $row['num_semana'];
                    $anioDB=$row['anio'];
                    for($i=0; $i<7; $i++){
                        if ($i == 0) {
                            $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB));
                        }
                        if ($i == 6) {
                            $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB));
                      }
                    }
                    $diaInicia=substr($inicia,0,2);
                    $mesInicia=substr($inicia,3,2);

                    $diaTermina=substr($termina,0,2);
                    $mesTermina=substr($termina,3,2);
                    
                    echo '<option class="" value='.$idPeriodo.'>Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioDB.'</option>';
                }
                $semanas = mysqli_query($conexion, $querySemanasDelAnioSiguiente);
                while ($row = mysqli_fetch_assoc($semanas)) {
                //se muestran las semanas disponibles
                  
                    $idPeriodo=$row['id'];
                    $week = $row['num_semana'];
                    $anioDB=$row['anio'];
                    for($i=0; $i<7; $i++){
                        if ($i == 0) {
                            $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB));
                        }
                        if ($i == 6) {
                            $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB));
                      }
                    }
                    $diaInicia=substr($inicia,0,2);
                    $mesInicia=substr($inicia,3,2);

                    $diaTermina=substr($termina,0,2);
                    $mesTermina=substr($termina,3,2);
                    
                    echo '<option class="" value='.$idPeriodo.'>Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioDB.'</option>';
                }
                ?>
            </select><?php  
            }//fin del IF
            elseif ($semanaActual<$semanaTermina) {//es el mismo año ?>
              <select class="form-control" id="exampleFormControlSelect1" name="semana" value="">
              <?php 
                $querySemanas = "SELECT * FROM semana WHERE ((id_residencia=$id) AND (disponible='si') AND (num_semana BETWEEN $semanaActual AND $semanaTermina))";
                $semanas = mysqli_query($conexion, $querySemanas);
                while ($row = mysqli_fetch_assoc($semanas)) {
                //se muestran las semanas disponibles
                    $idPeriodo=$row['id'];
                    $week = $row['num_semana'];
                    $anioDB=$row['anio'];
                    for($i=0; $i<7; $i++){
                        if ($i == 0) {
                            $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB));
                        }
                        if ($i == 6) {
                            $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB));
                      }
                    }
                    $diaInicia=substr($inicia,0,2);
                    $mesInicia=substr($inicia,3,2);

                    $diaTermina=substr($termina,0,2);
                    $mesTermina=substr($termina,3,2);
                    
                    echo '<option class="" value='.$idPeriodo.'>Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioDB.'</option>';
                }
                ?>
            </select><?php  
            }//fin del ELSEIF
            ?>
            </div>
            <br>
            <a style="color: white;" class="btn btn-primary" onclick="goBack()">Atras</a>
            <button type="submit" class="btn btn-primary">Crear Hotsale</button>
          </div>
        </form>
      </div>
    <hr>
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
    
      <div class="row">
        <div class="col-md-5">
          <a>
            <img class="img-fluid rounded mb-3 mb-md-0" 
            src="foto.php?id= <?php echo $id; ?>"
            alt="">
          </a>
        </div>
        <div class="col-md-7">
        <br>
        <p style="font-size: 15px;">Direccion:
          <?php echo $registro['direccion']; ?>
          </p>
          <p style="font-size: 15px;">Descripcion:
      <?php echo $registro['descrip']; ?>
          </p>
          <p style="font-size: 15px;">
      Capacidad:
      <?php echo $registro['capacidad']; ?>
          </p>
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
