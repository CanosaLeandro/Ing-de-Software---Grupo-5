<!DOCTYPE html>
<html lang="en">
<?php
include("DB.php");
$conexion = conectar();
?>

<head>
    <title>HSH &mdash; Subastar Residencia</title>
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
    
    $query = "SELECT * FROM residencia WHERE id=$id";
    $queryPeriodos = "SELECT * FROM periodo p INNER JOIN residencia r ON r.id = p.id_residencia WHERE r.id= $id ORDER BY semana";
    
    $resultResidencias = mysqli_query($conexion, $query);
    $resultPeriodos = mysqli_query($conexion, $queryPeriodos);

    $registroResidencias = mysqli_fetch_assoc($resultResidencias); 
    ?>

    <!-- Page Content -->
    <div class="container">
        <div class="jumbotron vertical-center">

            <!-- Page Heading -->
            <h1 class="display-4" align="center">
                <?php
                echo $registroResidencias['nombre'];
                ?>
                <br>
                <small>
                    <?php
                    echo $registroResidencias['ubicacion'];
                    ?>
                </small>
            </h1>
            <hr>
            <!-- Project One -->
            <div class="row">
                <div class="col-md-5">
                    <a>
                        <img class="img-fluid rounded mb-3 mb-md-0" src="foto.php?id= <?php echo $id; ?>" alt="">
                    </a>
                </div>
                <div class="col-md-7">
                    <form enctype='multipart/form-data' method="POST" id="inicioForm">
                        <label for="fecha">Fecha inicio de subasta: </label>
                        <br>
                        <input type="date" name="inicia" min="<?php echo date('Y-m-d'); ?>" value= "$fecha_inicio" required>
                        <p></p>
                        
                        <!--
                        <input type="week" id="periodo" <?php echo ("min=" . date('Y') . "-W" . (date('W') + 1) . " " .
                                                            "max=" . date('Y') . "-W" . (date('W') + 24)); ?>> 
                        -->
                        <input type="submit" value="Siguiente">                       
                    </form>
                    <?php 
                    #con la lectura del form anterior aparece la opcion elegir semana
                    if (isset($_POST['inicia'])){
                        $fechaInicio = strtotime($_POST['inicia']);
                    }
                    else {
                        $fecha_inicio = strtotime(date('Y-m-d'));
                    }
                    if (isset($fecha_inicio))
                    { @$fecha_actual=date("Y-m-d",time());//Establesco la fecha y hora de Bs.As 
           

                        #separas la fecha en subcadenas y asignarlas a variables
                        #relacionadas en contenido, por ejemplo dia, mes y anio.

                        $dia   = substr($fecha_actual,8,2);
                        $mes = substr($fecha_actual,5,2);
                        $anio = substr($fecha_actual,0,4);

                        $semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));?>
                    
                        <form action="addSubasta.php" enctype='multipart/form-data' method="POST" id="subastaForm">
                            <label for="fecha">Semana a subastar: </label>
                           <br>
                            <select name="periodo" form="subastaForm" required>
                               <?php
                                $querySemanas = "SELECT * FROM periodo WHERE id_residencia='$id' AND activa='si'";
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

                                    } 
                                }; ?>
                            </select>
                            <p></p>
                            <label for="monto_inicial">Monto mínimo a superar en la subasta:</label>
                            <br>
                            <input type="number" name="monto_inicial" min="0" required>
                            <input type="submit" value="Confirmar">
                            <input type="hidden" name="id_residencia" value="<?php echo $id ?>" >    
                        </form>
                    <?php } ?>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.container -->

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.slim.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>