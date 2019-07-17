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
    $queryPeriodos = "SELECT * FROM semana p INNER JOIN residencia r ON r.id = p.id_residencia WHERE r.id= $id ORDER BY num_semana";
    
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
                    <form action="selectSemanaASubastar.php" enctype='multipart/form-data' method="POST" id="inicioForm">
                        <br>
                        <label for="fecha">Fecha inicio de subasta</label>
                        <input id="fecha" type="date" name="inicia" min="<?php echo date('Y-m-d'); ?>" value= "" required>
                        <br>
                        <br>
                        <label for="hora">Hora de inicio </label>
                        <input id="hora" type="time" name="hora" value="" required>
                        <p></p>
                        <INPUT type="hidden" name="id" value="<?php echo $id ?>">
                        
                        <!--
                        <input type="week" id="periodo" <?php echo ("min=" . date('Y') . "-W" . (date('W') + 1) . " " .
                                                            "max=" . date('Y') . "-W" . (date('W') + 24)); ?>> 
                        -->
                        <a style="color: white;" class="btn btn-info" onclick="goBack()">Atras</a>                      
                    
                        <input class="btn btn-info" type="submit" value="Siguiente"> 
                        
                    
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