<!DOCTYPE html>
<html lang="en">
<?php
    Include("DB.php");
    $conexion = conectar();             
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
    
    $queryIdPuja = "SELECT puja_ganadora FROM subasta WHERE id =".$idSub;
    $resultIdPuja = mysqli_query($conexion, $queryIdPuja);
    $idSubPuja = mysqli_fetch_assoc($resultIdPuja)['puja_ganadora'];
    $queryPuja = "SELECT monto FROM puja WHERE id=".$idSubPuja;
    $resultPuja = mysqli_query($conexion, $queryPuja);
    $puja = mysqli_fetch_assoc($resultPuja)['monto'];
    
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
        <?php 
          
        ?>
        <!-- si la subasta ya empezo, debo poner el valor de la puja ganadora, sino debo poner el monto inicial -->
        <!-- si la subasta no empezo debo poner la fecha y hora de cuando se abre la subasta, si ya empezo no la muestro -->
        <div class="col-md-7">
          
            <?php
              $subastaEmpezo = false;
              $fechaInicio = $registro['inicia'];
              $fecha = date("d-m-Y",strtotime($fechaInicio));
              $hora = date("H:i",strtotime($fechaInicio));

              date_default_timezone_set('America/Argentina/Buenos_Aires');
              $zonahoraria = date_default_timezone_get();
              @$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.

              $subastaInicia=$registro['inicia'];
              /*$diferencia=date_diff($subastaInicia,$fecha_actual);
              echo $diferencia->format('%R%a días');
              echo "<script>alert('$diferencia');</script>";
              echo "<script>alert('$subastaInicia');</script>";
              echo "<script>alert('$fecha_actual');</script>";*/
              /*$fecha = '22. 11. 1968';*/
              
              
              //la fecha de inicio + 3 dias, que es lo que dura una subasta
              $fechaAux = date("Y-m-d",strtotime($subastaInicia."+ 3 days"));

              $inicioEjemplo = \DateTime::createFromFormat('d. m. Y', $subastaInicia);

              $terminaEjemplo = \DateTime::createFromFormat('d. m. Y', $fechaAux);

              echo "Fecha de Inicio: " . $inicioEjemplo->format('m/d/Y') . "\n";

              echo "Fecha de termina: " . $terminaEjemplo->format('m/d/Y') . "\n";

              if (($subastaInicia < $fecha_actual) AND ($fechaAux > $fecha_actual)) {//si la subasta ya empezo y no termino
                echo "<script>alert('llega');</script>";
                $subastaEmpezo = true;
                echo "<h4>Puja ganadora: ".$puja."</h4>";

              } 
              elseif (($subastaInicia>$fecha_actual)) {//si termino
                 echo "<script>alert('llegaalotro');</script>";
              }
              else{//si no empezo aun
                echo "<h4>La subasta comienza el ".$fecha." a las ".$hora."</h4><br><br>";
              }
            ?>
          
          <br><br><br>
          <?php 
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

            $diaTermina = substr($termina, 0,2);
            $mesTermina = substr($termina, 3, 2);
          ?>
          <p><b>Periodo de reserva</b></p>
          <i><?php echo "Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio;?></i>
          <button class="btn btn-primary" onclick="goBack()">Atras</button>
          <?php if ($subastaEmpezo) { ?><!-- si la subasta no empezo no muestro la opcion pujar -->
                  <form action="addPuja.php" method="POST">
                      <label for="monto">Monto a Pujar: </label>
                      <br>
                      <input type="number" class="form-control" name="monto" required min=<?php echo($puja+1);?>>
                      <br> <br>
                      <input type="hidden" name="idS" value="<?php echo $idSub ?>">
                      <input type="submit" value="Confirmar">                      
                  </form>
       
          <?php } ?>
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
