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
    $id = $_POST['id'];//id de la residencia
    $fecha_inicio = $_POST['inicia'];
    $hora=$_POST['hora'];
    
    $query = "SELECT * FROM residencia WHERE id=$id";
    /*$queryPeriodos = "SELECT * FROM periodo p INNER JOIN residencia r ON r.id = p.id_residencia WHERE r.id= $id AND p.activa= 'si' ORDER BY anio, semana DESC";*/

    $queryPeriodos="SELECT * FROM periodo WHERE id_residencia= '$id' AND periodo.activa= 'si' ORDER BY anio, semana";
    
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
            <?php 

            $fechaAux=$fecha_inicio;

            $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio."+ 6 months"));

            $dia   = substr($fecha_inicio,8,2);
            $mes = substr($fecha_inicio,5,2);
            $anio = substr($fecha_inicio,0,4);

            /*$semana es la semana de inicio aumentado 6 meses*/
            $semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));
            /*hago un switch porque con 01,02,..,09 no funciona la comparacion*/
            switch ($semana) {
                case '01':
                    $semana=1;
                    break;
                case '02':
                    $semana=2;
                    break;
                case '03':
                    $semana=3;
                    break;
                case '04':
                    $semana=4;
                    break;
                case '05':
                    $semana=5;
                    break;
                case '06':
                    $semana=6;
                    break;
                case '07':
                    $semana=7;
                    break;
                case '08':
                    $semana=8;
                    break;
                case '09':
                    $semana=9;
                    break;
            }
            ?>
            <div class="row">
                <div class="col-md-5">
                    <a>
                        <img class="img-fluid rounded mb-3 mb-md-0" src="foto.php?id= <?php echo $id; ?>" alt="">
                    </a>
                </div>
                <form action="addSubasta.php" enctype='multipart/form-data' method="POST" id="subastaForm">
                            <label for="fecha">Semana a subastar: </label>
                           <br>
                            <select name="periodo" form="subastaForm" required>
                               <option disabled>--Seleccione una semana libre--</option>
                               <?php  
                               $querySemanas = "SELECT * FROM periodo WHERE id_residencia='$id' AND activa='si'";
                              $semanas = mysqli_query($conexion, $querySemanas);
                              while ($row = mysqli_fetch_assoc($semanas)) {
                                //se muestran las semanas disponibles
                                $week = $row['semana'];
                                for($i=0; $i<7; $i++){
                                  if ($i == 0) {
                                      $inicia =date('d-m', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day')) . '<br />';
                                  }
                                  if ($i == 6) {
                                       $termina =date('d-m', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day')) . '<br />';
                                  }
                                }
                               
                                $anioDB=$row['anio'];

                                //$anio es el año de la fecha de inicio aumentado 6 meses
                                
                                if ($anio==2019) {
                                    if (($anioDB>=2020)&&($semana <= $week)){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                
                                    }
                                    elseif ($anioDB>=2020){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                
                                    }

                                }
                                elseif ($anio==2020) {
                                    if (($anioDB>=2020)&&($semana <= $week)){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                    }
                                    elseif ($anioDB>=2021){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                    }
                                }
                                elseif ($anio==2021) {
                                    if (($anioDB>=2021)&&($semana <= $week)){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                    }
                                    elseif ($anioDB>=2022){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                    }
                                }
                                elseif ($anio==2022) {
                                    if (($anioDB>=2022)&&($semana <= $week)){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                    }
                                    elseif ($anioDB>=2023){
                                                 
                                        echo '<option class="" value="'.$row["semana"].$anioDB.'">Comienza el día '.$inicia.'-'.$anioDB.' y termina el día '.$termina.'-'.$anioDB.'</option>';
                                    }
                                }

                            };?>
                               
                            </select>
                            <p></p>
                            <label for="monto_inicial">Monto mínimo a superar en la subasta:</label>
                            <br>
                            <input type="number" name="monto_inicial" min="0" required>
                            <input type="submit" value="Confirmar">
                            <input type="hidden" name="hora" value="<?php echo $hora; ?>">
                            <input type="hidden" name="inicia" value="<?php echo $fechaAux; ?>">
                            <input type="hidden" name="id_residencia" value="<?php echo $id; ?>" >    
                        </form>
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