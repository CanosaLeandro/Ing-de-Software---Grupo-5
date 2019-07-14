<!DOCTYPE html>
<html lang="en">
<?php
include("DB.php");
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

    $resultResidencias = mysqli_query($conexion, $query);
 

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

            $fecha_inicio = date("Y-m-d",strtotime($fecha_inicio));

            $dia   = substr($fecha_inicio,8,2);
            $mes = substr($fecha_inicio,5,2);
            $anio = substr($fecha_inicio,0,4);

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
                                $querySemanas = "SELECT * FROM semana WHERE id_residencia='$id' AND disponible='si'";
                                $semanas = mysqli_query($conexion, $querySemanas);
                                while ($row = mysqli_fetch_assoc($semanas)) {
                                //se muestran las semanas disponibles
                                    $week = $row['num_semana'];
                                    $anioDB=$row['anio'];
                                    for($i=0; $i<7; $i++){
                                        if ($i == 0) {
                                            $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB)) . '<br />';
                                        }
                                        if ($i == 6) {
                                            $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks sunday +' . $i . ' day'.$anioDB)) . '<br />';
                                      }
                                    }
                                    //strtotime("{$anioDB}W{$week} solo funciona con $week de dos digitos
                                    //los int empiezan en 1,2 por lo que hay que agregarle un 0 al inico                         
                                    if ($week<10){
                                        $week= str_pad($week, 2, '0', STR_PAD_LEFT);
                                    }
                                    //convierto las fechas a objetos DATE
                                    $fechaSemanaLunes= date("Y-m-d", strtotime("{$anioDB}W{$week}"));
                                    $fechaSemana= date("Y-m-d",strtotime($fechaSemanaLunes."-1 day"));
                                    $fecha_fin = date("Y-m-d",strtotime($fecha_inicio."+ 6 months"));
                                    $inicioDate = \DateTime::createFromFormat('Y-m-d', $fecha_inicio);
                                    $semanaDate = \DateTime::createFromFormat('Y-m-d', $fechaSemana);
                                    $terminaDate =\DateTime::createFromFormat('Y-m-d', $fecha_fin);
                                    //Muestra desde la semana siguiente a fecha de inicio hasta 6 meses despues de la misma
                                    $diaInicia=substr($inicia,0,2);
                                    $mesInicia=substr($inicia,3,2);

                                    $diaTermina=substr($termina,0,2);
                                    $mesTermina=substr($termina,3,2);
                                    $anioTermina = substr($termina,6,6);
                                    
                                    if (($semanaDate >= $inicioDate)&&($semanaDate < $terminaDate)){
                                        echo '<option class="" value="'.$week.$anioDB.'">Comienza el día '.$diaInicia.'-'.$mesInicia.'-'.$anioDB.' y termina el día '.$diaTermina.'-'.$mesTermina.'-'.$anioTermina.'</option>';
                                    }
                                };?>
                               
                            </select>
                            <p></p>
                            <label for="monto_minimo">Monto mínimo a superar en la subasta:</label>
                            <br>
                            <input type="number" name="monto_minimo" min="1" required>
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