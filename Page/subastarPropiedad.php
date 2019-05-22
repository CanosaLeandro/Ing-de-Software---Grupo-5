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
    $queryPeriodos = "SELECT fecha FROM periodo p INNER JOIN residencia r ON r.id = p.id_residencia WHERE r.id= $id";
    
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
                    <form action="addSubasta.php" enctype='multipart/form-data' method="POST" id="subastaForm">
                        <label for="fecha">Fecha a subastar: </label>
                        <br>
                        <!--
                        <input type="week" id="periodo" <?php echo ("min=" . date('Y') . "-W" . (date('W') + 1) . " " .
                                                            "max=" . date('Y') . "-W" . (date('W') + 24)); ?>> 
                        -->
                        <select name="semana" form="subastaForm">
                            <?php
                                while ($fila = mysqli_fetch_assoc($resultPeriodos)) {
                                    $fecha = $fila['fecha'];
                                    echo ('<option value='.$fecha.'>'."semana ".date("W-Y", strtotime($fecha)).'</option>');
                                }
                            ?>
                        </select>
                        <p> </p>
                        <label for="fecha">Fecha inicio de subasta: </label>
                        <br>
                        <input type="date" name="inicia">
                        <input type="submit" value="Confirmar">
                    </form>
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