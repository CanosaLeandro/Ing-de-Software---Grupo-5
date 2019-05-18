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

    if(isset($_GET['buscar'])){


        //Esta parte es el buscador
        if(isset($_GET['buscar'])){

            if (($_GET['categoria']!=='todos') and ($_GET['fecha'] =="")){//Si esta vacio fecha pero categoria no
                $categoria= $_GET['categoria'];
                header('Location: buscar.php?c='.$categoria);
            }
            else if (($_GET['categoria']=="todos") and !($_GET['fecha'] =="")){//Si esta vacio categoria pero fecha no
                $fecha= $_GET['fecha'];
                header('Location: buscar.php?f='.$fecha);
            }
            else if(!($_GET['categoria']=="todos") and !($_GET['fecha'] =="")){//Si ninguno esta vacio
                $fecha= $_GET['fecha'];
                $categoria= $_GET['categoria'];
                header('Location: buscar.php?c='.$categoria.'&f='.$fecha);
            }
            else header("Location:".$_SERVER['HTTP_REFERER']);//Si estan vacios los dos
        }

    };


            //cantidad de registros por pagina
            $por_pagina = 5;

            //si se presiono algun indice de la paginacion
            if(isset($_GET['pagina'])){
                $pagina = $_GET['pagina'];
            }else{
                $pagina = 1;
            }

            //la pagina inicia en 0 y se multiplica por $por_pagina

            $empieza = ($pagina - 1) * $por_pagina;

            $query = "SELECT * FROM residencia WHERE en_subasta = 'si' ORDER BY ubicacion LIMIT $empieza, $por_pagina";
            $resultado = mysqli_query($conexion, $query);
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
                                <form>
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
                                    $id = $fila['id'];$j++;
                            ?>
                            <tr>
                                <td><?php echo $id;?></td>
                                <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                                <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                                <td><?php echo $fila['capacidad'];?></td>
                                <td><?php echo utf8_encode(utf8_decode($fila['ubicacion']));?></td>
                                <td><?php echo utf8_encode($fila['descrip']);?></td>
                                <td>
                                    <a href="#addEmployeeModal"><button type="button" class="btn btn-info"><span>Ver Subasta</span></button></a>
                                </td>
                            </tr> 
                            <?php };?>
                        </tbody>
                    </table>
                    <?php
                        $qry="SELECT * FROM residencia WHERE en_Subasta = 'si'";
            
                        $result = mysqli_query($conexion, $qry);
                        //contar el total de registros
                        $total_registros = mysqli_num_rows($result);
                    ?>
                    <div class="clearfix">
                        <?php
                        if(isset($total_registros)) {

                        if($total_registros>5) {

                            //usando ceil para dividir el total de registros entre $por_pagina
                            //ceil redondea un numero para abajo
                            $total_paginas = ceil($total_registros / $por_pagina);

                        ?>
                        <div class="hint-text">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros;?></b> registros</div>
                        <ul class="pagination">
                            
                        <?php
                            //link a la primera pagina
                            echo "<li class='page-item'><a href='buscar.php?pagina=1'>".'Primeros registros'."</a></li>";


                            for($i=2; $i < $total_paginas-1; $i++){ 
                                    echo "<li class='page-item'><a href='buscar.php?pagina=".$i."' class='page-link'>".$i."</a></li>";
                            }
                            

                            //link a la ultima pagina
                            echo "<li class='page-item'><a href='buscar.php?pagina=$total_paginas' class='page-link'>".'Ultimos registros'."</a></li>";

                        }}
                        ?>
                        
                        </ul>
                    </div>
                </div>
            </div>

</body>
</html>                                                                 