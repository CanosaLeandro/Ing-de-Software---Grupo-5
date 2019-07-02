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
    <title>HSH &mdash; Residencias</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
  </head>
  <?php 
    $idSub = $_GET['id'];
    $query = "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.semana, s.inicia, r.id AS idResi, s.id AS idSubasta 
              FROM residencia r 
              INNER JOIN subasta s ON r.id = s.id_residencia
              WHERE s.id = '$idSub'";

    $resultado = mysqli_query($conexion, $query);
    $registro = mysqli_fetch_assoc($resultado);
    
    //puja maxima
    $queryIdPuja = "SELECT * FROM subasta WHERE id = $idSub";
    $resultIdPuja = mysqli_query($conexion, $queryIdPuja);

    //$idSubPuja tiene el id de la puja que va ganando
    $subasta=mysqli_fetch_assoc($resultIdPuja);
    $idSubPuja = $subasta['puja_ganadora'];
    $puja = $subasta['monto_inicial'];
   
    //obtengo el monto que va ganando
    $queryPuja = "SELECT * FROM puja WHERE id= $idSubPuja";
    $resultPuja = mysqli_query($conexion, $queryPuja);
    $numrows=mysqli_num_rows($resultPuja);
    if($numrows!=0){//esto quiere decir que ya hay una puja
      $puja = mysqli_fetch_assoc($resultPuja)['monto'];
      //$puja tiene el monto que va ganando
    }
    
  ?>
 <body>
<!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4"><?php echo $registro['nombre'];?>
        <small><?php echo $registro['ubicacion'];?></small>
      </h1>

      <!-- Project One -->
      <div class="row">
        <div class="col-md-5">
          <a href="residencia.php?id=<?php echo $registro['idResi'];?>">
            <img class="img-fluid rounded mb-3 mb-md-0" src="foto.php?id=<?php echo $registro['idResi'];?>" alt="">
          </a>
        </div>
        
   
        <div class="col-md-7">
          
            <?php
              $fechaInicio = $registro['inicia'];
              $fecha = date("d-m-Y",strtotime($fechaInicio));
              $hora = date("H:i",strtotime($fechaInicio));

              date_default_timezone_set('America/Argentina/Buenos_Aires');
              $zonahoraria = date_default_timezone_get();
              @$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.
              
              $subastaInicia=$registro['inicia'];
              
              //la fecha de inicio + 3 dias, que es lo que dura una subasta
              $fechaAux = date("Y-m-d H:i:s",strtotime($subastaInicia."+ 3 days"));
              
              //dia,mes y año del inicio de la subasta
              $diaInicioEjemplo = substr($subastaInicia, 8,2);
              $mesInicioEjemplo = substr($subastaInicia, 5, 2); 
              $anioInicioEjemplo = substr($subastaInicia, 0, 4); 
              $horaInicioEjemplo = substr($subastaInicia, 10,2);
              $minutosInicioEjemplo = substr($subastaInicia, 12,2);

              //dia en que termina la subasta
              $diaTerminaEjemplo = substr($fechaAux, 8,2);
              $mesTerminaEjemplo = substr($fechaAux, 5, 2); 
              $anioTerminaEjemplo = substr($fechaAux, 0, 4); 
              $horaTerminaEjemplo = substr($fechaAux, 10,3);
              $minutosTerminaEjemplo = substr($fechaAux, 14,2);

              //dia,mes y año actual
              $diaFechaAct = substr($fecha_actual, 8,2);
              $mesFechaAct = substr($fecha_actual, 5, 2); 
              $anioFechaAct = substr($fecha_actual, 0, 4);
              $horaFechaAct = substr($fecha_actual, 10, 2); 
              $minutosFechaAct = substr($fecha_actual, 12, 2); 
     
              $idPeriodo=$registro['semana'];
              $semanaQuery="SELECT * FROM periodo WHERE id = '$idPeriodo'";
              $resultadoSemana=mysqli_query($conexion,$semanaQuery);

              $registroSemana=mysqli_fetch_assoc($resultadoSemana);
              $week=$registroSemana['semana'];
              $anio=$registroSemana['anio'];
              for($i=0; $i<7; $i++){
                if ($i == 0) {
                    $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $i . ' day')) . '<br />';
                }
                if ($i == 6) {
                     $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $i . ' day')) . '<br />';
                }
              }

              $diaInicia = substr($inicia, 0,2);
              $mesInicia = substr($inicia, 3, 2); 
              $anioInicia = substr($inicia, 6, 4);

              $diaTermina = substr($termina, 0,2);
              $mesTermina = substr($termina, 3, 2);
              $anioTermina = substr($termina, 6, 4);
            
              $pujaMinima=($puja+1);
              
              //aca chequeo si empezo y no termino la subasta
              if ($anioFechaAct == $anioInicioEjemplo) {//tienen el mismo año
                  //si el año es igual, hay que chequear el mes
                  if ($mesFechaAct == $mesInicioEjemplo) {//tienen el mismo mes
                      //chequeo que la subasta inicio y no termino
                      if (($diaFechaAct>=$diaInicioEjemplo)&&($diaFechaAct < $diaTerminaEjemplo)) {

                        //ahora chequeo la hora de inicio
                        if ($horaFechaAct>=$horaInicioEjemplo){//si es mayor o igual a la hora actual
                          if ($horaFechaAct>$horaInicioEjemplo) {//si la hora actual paso la hora en que inicia la subasta, entonces comienza la subasta
                                //entonces la subasta ya empezo
                                echo "<h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                <p><b>Periodo de reserva</b></p>
                                <i>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i> 
                                </br></br>
                                <form action='addPuja.php' method='POST'>
                                    <label for='monto'>Monto a Pujar: </label>
                                    <br>
                                    <input type='number' class='form-control' name='monto' required min='".$pujaMinima."'>
                                    <br> <br>
                                    <input type='hidden' name='idS' value='".$idSub."'>
                                    <input type='hidden' name='idP' value='".$idPeriodo."'>
                                    <input type='button' class='btn btn-primary' value='Atras' onclick='goBack()'>
                                    <input style='background-color:#3A9FF4;
                                    border-color:#3A9FF4;' class='btn btn-primary' type='submit' value='Confirmar'>                      
                                </form>";
                          //si tienen la misma hora, hay que chequear los minutos
                          }elseif ($horaFechaAct==$horaInicioEjemplo) {
                              if ($minutosFechaAct>=$minutosInicioEjemplo) {
                                //entonces la subasta ya empezo
                                echo "<h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                <p><b>Periodo de reserva</b></p>
                                <i>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i> 
                                </br></br>
                                <form action='addPuja.php' method='POST'>
                                    <label for='monto'>Monto a Pujar: </label>
                                    <br>
                                    <input type='number' class='form-control' name='monto' required min='".$pujaMinima."'>
                                    <br> <br>
                                    <input type='hidden' name='idS' value='".$idSub."'>
                                    <input type='hidden' name='idP' value='".$idPeriodo."'>
                                    <input type='button' class='btn btn-primary' value='Atras' onclick='goBack()'>
                                    <input style='background-color:#3A9FF4;
                                    border-color:#3A9FF4;' class='btn btn-primary' type='submit' value='Confirmar'>                      
                                </form>";
                              }
                          }
                        }
                      }
                  }
              }
              //aca chequeo si todavia no empezo la subasta
              if($anioFechaAct <= $anioInicioEjemplo){//la subasta no comenzo todavia
                  //si el año es igual, hay que chequear el mes
                  if ($mesFechaAct<$mesInicioEjemplo) {//la subasta no comenzo todavia
                      //aca hay que mostra la fecha en que inicia la subasta
                      echo "<h4>La subasta comienza el ".$fecha." a las ".$hora."</h4><br><br>
                      <p><b>Semana a subastar</b></p>
                      <i>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i> 
                      </br></br>
                      <button class='btn btn-primary' onclick='goBack()'>Atras</button>";
                  }elseif($mesFechaAct==$mesInicioEjemplo){//ESTAN EN EL MISMO MES
                      if ($diaFechaAct<$diaInicioEjemplo) {//la subasta no comenzo todavia
                          //aca hay que mostra la fecha en que inicia la subasta
                           echo "<h4>La subasta comienza el ".$fecha." a las ".$hora."</h4><br><br>
                          <p><b>Semana a subastar</b></p>
                          <i>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i> 
                          </br></br>
                          <button class='btn btn-primary' onclick='goBack()'>Atras</button>";
                      }elseif ($diaFechaAct==$diaInicioEjemplo) {//es el mismo dia
                        //cheque la hora y los minutos
                        if ($horaFechaAct<=$horaInicioEjemplo){
                            if ($minutosFechaAct<=$minutosInicioEjemplo) {
                                //aca hay que mostra la fecha en que inicia la subasta
                                 echo "<h4>La subasta comienza el ".$fecha." a las ".$hora."</h4><br><br>
                                <p><b>Semana a subastar</b></p>
                                <i>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i> 
                                </br></br>
                                <button class='btn btn-primary' onclick='goBack()'>Atras</button>";
                            }
                        }
                      }
                  }
              }
              //aca chequeo si ya termino la subasta
              if($anioFechaAct == $anioInicioEjemplo){
                  //si el año es igual, hay que chequear el mes
                  if ($mesFechaAct>$mesInicioEjemplo) {//si ya paso el mes
                      //entonces la subasta ya termino
                      echo "La subasta ya termino";
                  }elseif($mesFechaAct==$mesInicioEjemplo){//SI ESTAN EN EL MISMO MES
                      if ($diaFechaAct>=$diaTerminaEjemplo) {//la subasta ya termino
                          if ($horaFechaAct>=$horaInicioEjemplo) {
                            //si la hora es igual chequeo los minutos
                              if ($minutosFechaAct>$minutosInicioEjemplo) {
                                //estonces la subasta termino
                                echo "La subasta ya termino";
                              }
                          }
                      }
                  }
              }elseif ($anioFechaAct > $anioInicioEjemplo) {
                //estonces la subasta termino
                  echo "La subasta ya termino";

              }
            ?>
          
          <br><br><br>
        </div>
      </div>
      <!-- /.row -->
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
