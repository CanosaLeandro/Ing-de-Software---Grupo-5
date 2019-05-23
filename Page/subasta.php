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
    $id = $_GET['id'];
    $query = "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.periodo, s.inicia, r.id AS idResi, s.id AS idSubasta 
              FROM residencia r 
              INNER JOIN subasta s ON r.id = s.id_residencia
              WHERE r.id = $id";
    $resultado = mysqli_query($conexion, $query);
    $registro = mysqli_fetch_assoc($resultado);
    $queryIdPuja = "SELECT puja_ganadora FROM subasta WHERE id = $id ";
    $resultIdPuja = mysqli_query($conexion, $queryIdPuja);
    $idPuja = mysqli_fetch_assoc($resultIdPuja);
    $queryPuja = "SELECT monto FROM puja WHERE id = $idPuja[puja_ganadora] ";
    $resultPuja = mysqli_query($conexion, $queryPuja);
    $puja = mysqli_fetch_assoc($resultPuja);
    
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
              @$fecha_actual=date("d-m-Y s:i:H",time());//Establesco la fecha y hora de Bs.As.

              if ($registro['inicia'] < $fecha_actual) {//si la subasta ya empezo
                $subastaEmpezo = true;
                echo "<h4>Puja ganadora: ".$puja['monto']."</h4>";
                } 
              else{
                echo "<h4>La subasta comienza el ".$fecha." a las ".$hora."</h4><br><br>";
              }
            ?>
          
          <br><br><br>
          <?php 
            $diaInicial = date("d-m-Y",strtotime($registro['periodo']));
            $diaFinal = date("d-m-Y",strtotime($diaInicial."+ 7 days")); 
          ?>
          <p><b>Periodo de reserva</b><br> <i>Del día <?php echo $diaInicial; ?> al día <?php echo $diaFinal; ?></i></p>
          <button class="btn btn-primary" onclick="goBack()">Atras</button>
          <?php if ($subastaEmpezo) { ?><!-- si la subasta no empezo no muestro la opcion pujar -->
                  <form action="addPuja.php" method="POST">
                      <label for="monto">Monto a Pujar: </label>
                      <br>
                      <input type="number" name="monto" min=<?php echo($puja['monto']+1);?> class="form-control" required>
                      <br> <br>
                      <input type="submit" value="Confirmar">
                      <input type="hidden" name="idS" value="<?php echo $id ?>">
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
