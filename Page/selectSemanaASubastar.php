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
    $id = $_POST['id'];
    $fecha_inicio = $_POST['inicia'];
    
    $query = "SELECT * FROM residencia WHERE id=$id";
    $queryPeriodos = "SELECT * FROM periodo p INNER JOIN residencia r ON r.id = p.id_residencia WHERE r.id= $id AND p.activa= 'si' ORDER BY semana";
    
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
                <form action="addSubasta.php" enctype='multipart/form-data' method="POST" id="subastaForm">
                            <label for="fecha">Semana a subastar: </label>
                           <br>
                            <select name="periodo" form="subastaForm" required>
                               <option disabled>--Seleccione una semana libre--</option>
                               <?php
                                   while ($fila = mysqli_fetch_assoc($resultPeriodos)) {
                                        
                                        $semana = $fila['semana'];
                                        $anio = $fila['anio'];
                                        $j= $semana * 7;
							            $date= strtotime("+ $j day");
                                        $fecha = date('y-m-d',$date);
                                        if(($fecha - $fecha_inicio) < 180 ){ #comprueba que la subasta sea hasta 6 meses
                                            echo ('<option value='.$fecha.'>'."Semana del ".date("d/m", strtotime($fecha))." del año ".($anio).'</option>');                      
                                        }
                                    }
                                ?>
                            </select>
                            <p></p>
                            <label for="monto_inicial">Monto mínimo a superar en la subasta:</label>
                            <br>
                            <input type="number" name="monto_inicial" min="0" required>
                            <input type="submit" value="Confirmar">
                            <input type="hidden" name="año" value="<?php echo $anio; ?>">
                            <input type="hidden" name="inicia" value="<?php echo $fecha_inicio; ?>">
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