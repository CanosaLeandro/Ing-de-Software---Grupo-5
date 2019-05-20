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
    <title>Busqueda de subastas</title>
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

        if ($_GET['ubicacion']==""){
            $fechaDesde= $_GET['fechaDesde'];
            $fechaHasta= $_GET['fechaHasta'];
            $query= "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.periodo, r.id AS idResi, s.id AS idSubasta FROM residencia r
            INNER JOIN subasta s ON r.id = s.id_residencia
            WHERE date_format(s.periodo, '%Y-%m') BETWEEN '$fechaDesde' AND '$fechaHasta' ORDER BY ubicacion";
            $resultado = mysqli_query($conexion, $query);     
        }
        else if (!$_GET['ubicacion']==""){
            $fechaDesde= $_GET['fechaDesde'];
            $fechaHasta= $_GET['fechaHasta'];
            $ubicacion= $_GET['ubicacion'];
            $query= "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.periodo, r.id AS idResi, s.id AS idSubasta FROM residencia r
            INNER JOIN subasta s ON r.id = s.id_residencia
            WHERE (date_format(s.periodo, '%Y-%m') BETWEEN '$fechaDesde' AND '$fechaHasta') AND (r.ubicacion = '$ubicacion') ORDER BY ubicacion";
            $resultado = mysqli_query($conexion, $query);       
        }
       
    }
?>
<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>Buscar <b>Subastas</b></h2>
                    </div>

                    <!-- buscador por rangos de fechas -->
                    <div class="col-sm-4">
                        <form action="buscadorSubasta.php" method="GET">
                            <div class="form-group">
                              <label for="disabledTextInput">Fecha Inicio</label>
                              <input type="month" id="disabledTextInput" class="form-control" name="fechaDesde" value="<?php echo $fechaDesde;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledTextInput">Fecha Fin</label>
                              <input type="month" id="disabledTextInput" class="form-control" name="fechaHasta" value="<?php echo $fechaHasta;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledSelect">Ubicación</label>
                              <input type="text" id="disabledSelect" class="form-control" name="ubicacion" value="" placeholder="">
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                    
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nro de subasta</th>
                        <th>Nombre</th>
                        <th>Portada</th>
                        <th>Capacidad</th>
                        <th>Ubicación</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['idResi'];$j++;
                    ?>
                    <tr>
                        <td><?php echo $id;?></td>
                        <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                        <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                        <td><?php echo $fila['capacidad'];?></td>
                        <td><?php echo utf8_encode(utf8_decode($fila['ubicacion']));?></td>
                        <td><?php echo utf8_encode($fila['descrip']);?></td>
                        <td>
                            <a href='subasta.php?id=<?php echo $id;?>'><button type="button" class="btn btn-info"><span>Ver Subasta</span></button></a>
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