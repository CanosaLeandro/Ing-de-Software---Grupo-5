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
                if ($registro['monto_inicial'] > $registro['puja_ganadora']) {//si el monto inicial es mayor a la puja
                  echo "<h4>Monto inicial de la subasta: ".$registro['monto_inicial']."</h4>";
                }else{
                  echo "<h4>Puja ganadora: ".$registro['puja_ganadora']."</h4>";
                } 
              }else{
                  echo "<h4>La subasta comienza el ".$fecha." a las ".$hora."</h4><br><br>";
                  echo "Monto inicial de la subasta: ".$registro['monto_inicial']."&#36";
              }
            ?>
          
          <br><br><br>
          <?php 
            $diaInicial = date("d-m-Y",strtotime($registro['periodo']));
            $diaFinal = date("d-m-Y",strtotime($diaInicial."+ 7 days")); ?>
          <p><b>Periodo de reserva</b><br> <i>Comienza el <?php echo $diaInicial; ?> y termina el <?php echo $diaFinal; ?></i></p>
          <?php if ($subastaEmpezo) { ?><!-- si la subasta no empezo no muestro la opcion pujar -->
                  <a class="btn btn-primary" href="">PUJAR</a>
          <?php } ?>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->


  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
