<!DOCTYPE html>
<html lang="es">
<?php
    Include("DB.php");
    $conexion = conectar();             
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busqueda de Ubicación</title>
    <link rel="shortcut icon" type="image/x-icon" href="Logos/Logos/favicon.png" /> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_crudResidencia.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php 
    //Esta parte es el buscador
    if(isset($_GET['buscar'])){
        $ubicacion= $_GET['ubicacion'];
        $query= "SELECT * FROM residencia
        WHERE ubicacion = '$ubicacion'";
        $resultado = mysqli_query($conexion, $query);       
    }
?>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>Buscar por <b>Ubicación</b></h2>
                    </div>

                    <!-- buscador por rangos de fechas -->
                    <div class="col-sm-4">
                        <form action="buscadorUbicacion.php" method="GET">
                            <div class="form-group">
                              <label for="disabledSelect">Ubicación</label>
                              <input type="text" id="disabledSelect" class="form-control" name="ubicacion" value="" placeholder="" required>
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                    
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Portada</th>
                        <th>Capacidad</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['id'];$j++;
                    ?>
                    <tr>
                        <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                        <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                        <td><?php echo $fila['capacidad'];?></td>
                        <td><?php echo utf8_encode($fila['descrip']);?></td>
                        <td>
                            <a href='residencia.php?id=<?php echo $id;?>'><button type="button" class="btn btn-info"><span>Ver Residencia</span></button></a>
                        </td>
                    </tr> 
                    <?php };
                    if($j == 0){
                        echo "<script>alert('No se encontraron resultados');</script>";
                    }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>                                                                 