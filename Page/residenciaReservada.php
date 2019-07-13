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
		$id = $_GET['id'];
		$query = "SELECT * FROM residencia WHERE id=$id";
		$result = mysqli_query($conexion, $query);
		$registro = mysqli_fetch_assoc($result);

    $idUser=$_SESSION['id'];
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
    <br>
        <small>
        <?php
    			echo $registro['direccion'];
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
		  
          <p>Descripcion:
			<?php echo $registro['descrip']; ?>
          </p>
          <br>
          <p>
			Capacidad:
			<?php echo $registro['capacidad']; ?>
          </p>
          <p>Semana reservada</p>
          <?php 
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $zonahoraria = date_default_timezone_get();
            @$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 

            $dia   = substr($fecha_actual,8,2);
            $mes = substr($fecha_actual,5,2);
            $anio = substr($fecha_actual,0,4);

            $semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));  

            switch ($dia) {
              case '01':
                $dia=1;
                break;
              case '02':
                $dia=2;
                break;
              case '03':
                $dia=3;
                break;
              case '04':
                $dia=4;
                break;
              case '05':
                $dia=5;
                break;
              case '06':
                $dia=6;
                break;
              case '07':
                $dia=7;
                break;
              case '08':
                $dia=8;
                break;
              case '09':
                $dia=9;
                break;
            }
            switch ($mes) {
              case '01':
                $mes=1;
                break;
              case '02':
                $mes=2;
                break;
              case '03':
                $mes=3;
                break;
              case '04':
                $mes=4;
                break;
              case '05':
                $mes=5;
                break;
              case '06':
                $mes=6;
                break;
              case '07':
                $mes=7;
                break;
              case '08':
                $mes=8;
                break;
              case '09':
                $mes=9;
                break;
            }
          ?>
        <form method="POST" action="cancelarReserva.php">
          <div class="form-group">
            <select class="form-control" id="exampleFormControlSelect1" name="semana" value="">
              <?php 
              //cuantas reservas hizo el usuario para esa residencia
              $querySemanas = "SELECT * FROM reserva WHERE id_residencia=$id AND id_usuario=$idUser";
              $semanas = mysqli_query($conexion, $querySemanas);
              while ($row = mysqli_fetch_assoc($semanas)) {
                //se muestran las semanas disponibles
                $idPeriodo = $row['id_semana'];
                $query="SELECT * FROM semana WHERE id=$idPeriodo";
                $resultIdPeriodo=mysqli_query($conexion,$query);
                $registro=mysqli_fetch_assoc($resultIdPeriodo);
                $anioDB=$registro['anio'];
                $week = $registro['num_semana'];
                
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
                switch ($diaInicia) {
                  case '01':
                    $diaInicia=1;
                    break;
                  case '02':
                    $diaInicia=2;
                    break;
                  case '03':
                    $diaInicia=3;
                    break;
                  case '04':
                    $diaInicia=4;
                    break;
                  case '05':
                    $diaInicia=5;
                    break;
                  case '06':
                    $diaInicia=6;
                    break;
                  case '07':
                    $diaInicia=7;
                    break;
                  case '08':
                    $diaInicia=8;
                    break;
                  case '09':
                    $diaInicia=9;
                    break;
                }
                switch ($mesInicia) {
                  case '01':
                    $mesInicia=1;
                    break;
                  case '02':
                    $mesInicia=2;
                    break;
                  case '03':
                    $mesInicia=3;
                    break;
                  case '04':
                    $mesInicia=4;
                    break;
                  case '05':
                    $mesInicia=5;
                    break;
                  case '06':
                    $mesInicia=6;
                    break;
                  case '07':
                    $mesInicia=7;
                    break;
                  case '08':
                    $mesInicia=8;
                    break;
                  case '09':
                    $mesInicia=9;
                    break;
                }
                
                $diaTermina=substr($termina,0,2);
                $mesTermina=substr($termina,3,2);

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

                if($anio == $anioDB){//la subasta no comenzo todavia
                  //si el año es igual, hay que chequear el mes
                  if ($mes<$mesInicia) {//la subasta no comenzo todavia
                      //aca hay que mostra la fecha en que inicia la subasta
                      echo '<option class="" value="'.$idPeriodo.'">Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioTermina.'</option>';
                  }elseif($mes==$mesInicia){//ESTAN EN EL MISMO MES
                      if ($dia<$diaInicia) {//la subasta no comenzo todavia
                          echo '<option class="" value="'.$idPeriodo.'">Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioDB.'</option>';
                      }
                  }
                }elseif($anio<$anioDB){
                  echo '<option class="" value="'.$idPeriodo.'">Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioDB.'</option>';
                }
                
              }; ?>
            </select>
          </div>
          <div class="form-group">
            <input type="hidden" name="idResidencia" value="<?php echo $id;?>">
            <a style="color: white;" class="btn btn-info" onclick="goBack()">Atras</a>
            <button type="submit" class="btn btn-danger">Cancelar reserva</button>
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
