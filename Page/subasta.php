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
    $query = "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.periodo, r.id AS idResi, s.id AS idSubasta 
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
        <div class="col-md-7">
          <a href="residencia.php?id=<?php echo $registro['idResi'];?>">
            <img class="img-fluid rounded mb-3 mb-md-0" src="foto.php?id=<?php echo $registro['idResi'];?>" alt="">
          </a>
        </div>
        <!-- si la subasta ya empezo, debo poner el valor de la puja ganadora, sino debo poner el monto inicial -->
        <!-- si la subasta no empezo debo poner la fecha y hora de cuando se abre la subasta, si ya empezo no la muestro -->
        <div class="col-md-5">
          <h3>Puja ganadora:
            <?php 
              if ($registro['monto_inicial'] > $registro['puja_ganadora']) {
                echo $registro['monto_inicial'];
              }else{
                echo $registro['puja_ganadora'];
              } 
            ?>
          </h3>
          <br>
          <p>Semana de reserva: <?php echo $registro['periodo']; ?></p>
          <a class="btn btn-primary" href="">PUJAR</a>
        </div>
      </div>
      <!-- /.row -->


    </div>
    <!-- /.container -->


  
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.slim.min.js"></script>

  </body>
</html>
