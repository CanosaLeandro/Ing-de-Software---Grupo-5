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
    <link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
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

            $diaFD = substr($fechaDesde,8,2);
            $mesFD = substr($fechaDesde,5,2);
            $anioFD = substr($fechaDesde,0,4);

            //PARA EL DIA DE FECHA DE INICIO
            switch ($diaFD) {
                case '01':
                    $diaFD=1;
                    break;
                case '02':
                    $diaFD=2;
                    break;
                case '03':
                    $diaFD=3;
                    break;
                case '04':
                    $diaFD=4;
                    break;
                case '05':
                    $diaFD=5;
                    break;
                case '06':
                    $diaFD=6;
                    break;
                case '07':
                    $diaFD=7;
                    break;
                case '08':
                    $diaFD=8;
                    break;
                case '09':
                    $diaFD=9;
                    break;
            }

            //PARA EL MES DE FECHA DE INICIO
            switch ($mesFD) {
                case '01':
                    $mesFD=1;
                    break;
                case '02':
                    $mesFD=2;
                    break;
                case '03':
                    $mesFD=3;
                    break;
                case '04':
                    $mesFD=4;
                    break;
                case '05':
                    $mesFD=5;
                    break;
                case '06':
                    $mesFD=6;
                    break;
                case '07':
                    $mesFD=7;
                    break;
                case '08':
                    $mesFD=8;
                    break;
                case '09':
                    $mesFD=9;
                    break;
            }

            $diaFH   = substr($fechaHasta,8,2);
            $mesFH = substr($fechaHasta,5,2);
            $anioFH = substr($fechaHasta,0,4);

            //PARA EL DIA DE FECHA DE FIN
            switch ($diaFH) {
                case '01':
                    $diaFH=1;
                    break;
                case '02':
                    $diaFH=2;
                    break;
                case '03':
                    $diaFH=3;
                    break;
                case '04':
                    $diaFH=4;
                    break;
                case '05':
                    $diaFH=5;
                    break;
                case '06':
                    $diaFH=6;
                    break;
                case '07':
                    $diaFH=7;
                    break;
                case '08':
                    $diaFH=8;
                    break;
                case '09':
                    $diaFH=9;
                    break;
            }

            //PARA EL MES DE FECHA DE FIN
            switch ($mesFH) {
                case '01':
                    $mesFH=1;
                    break;
                case '02':
                    $mesFH=2;
                    break;
                case '03':
                    $mesFH=3;
                    break;
                case '04':
                    $mesFH=4;
                    break;
                case '05':
                    $mesFH=5;
                    break;
                case '06':
                    $mesFH=6;
                    break;
                case '07':
                    $mesFH=7;
                    break;
                case '08':
                    $mesFH=8;
                    break;
                case '09':
                    $mesFH=9;
                    break;
            }



            if ($anioFD == $anioFH){
                if(($mesFD==$mesFH)){//si busca en el mismo mes


                    //obtengo todas las semana del rango buscado
                    //todavia me falta chequear el año

                    //esta es la consulta que tengo que hacer, mas o menos
                    /*SELECT * FROM semana WHERE (num_semana BETWEEN 1 AND 52) AND (anio = '2020') AND (en_subasta='si')*/


                    $query="SELECT * FROM semana WHERE num_semana BETWEEN $semanaInicio AND $semanaTermina";
                    $resultado = mysqli_query($conexion, $query);
                    $arraySemanas=mysqli_fetch_assoc($resultado);

                    $idSemana=$arraySemanas['id'];
                    $querySubasta="SELECT * FROM subasta WHERE id_semana=$idSemana";
                    $resultadoSubasta = mysqli_query($conexion, $querySubasta);
                    $arraySubasta=mysqli_fetch_assoc($resultadoSubasta);

                    /*$query= "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_minimo, s.puja_ganadora, s.inicia, s.id_semana, r.id AS idResi, s.id AS idSubasta FROM residencia r
                    INNER JOIN subasta s ON r.id = s.id_residencia
                    WHERE (date_format(s.id_semana, '%Y-%m') BETWEEN '$fechaDesde' AND '$fechaHasta')";*/
                    

                    
                }
                elseif(($mesFD+1)==$mesFH){//si busca en un rango de un mes
                    # code...
                }
                elseif(($mesFD+2)==$mesFH){//si busca en un rango de dos meses
                }
                else{
                    echo "ERROR. supera el rango de busqueda";
                }
            }
            /*

            //semana fecha desde
            $semanaFD = date('W', mktime(0,0,0,$mesFD,$diaFD,$anioFD)); 

            //semana fecha hasta
            $semanaFH = date('W', mktime(0,0,0,$mesFH,$diaFH,$anioFH)); 


            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $zonahoraria = date_default_timezone_get();
            @$fecha_actual=date("d-m-Y",time());//Establesco la fecha y hora de Bs.As

            $diaActual = substr($fecha_actual,8,2);
            $mesActual = substr($fecha_actual,5,2);
            $anioActual = substr($fecha_actual,0,4);

            $semanaActual = date('W',  mktime(0,0,0,$mesActual,$diaActual,$anioActual));*/

            //aca se chequea que sea una busqueda valida
            /*if ($semanaFD > $semanaFH) {//no tendria sentido esta busqueda
                echo '<script>alert("RANGO DE BUSQUEDA NO VALIDO!, la fecha inicial debe ser menor o igual a la fecha final.");
                    window.location = "buscar.php";</script>';
            }*/

            /*$fecha_actual = date("d-m-Y",strtotime($fecha_actual));*/
            /*$fd = date("m-Y",strtotime($fechaDesde));*/

            /*if ($semanaActual > $semanaFD) {//si realiza un busqueda con valores inferior al mes actual
                echo '<script>alert("ERROR AL BUSCAR!, la fecha de inicio del rango debe ser igual o mayor a la fecha actual.");
                    window.location = "buscar.php";</script>';
            }*/

            //le aumento 6 meses a la fecha actual
            /*$fecha_actual = date("d-m-Y",strtotime($fecha_actual."+ 6 months"));*/

            //cambio el formato de la fecha actual para que no muestre los dias
            /*$fecha_actual = date("m-Y",strtotime($fecha_actual));
            $fd = date("m-Y",strtotime($fechaDesde));*/
/*
            $semanaActual+=6;
            //aca se chequea si no busco en los primeros 6 meses
            if ($semanaFD < $semanaActual) {//si busca en una fecha menor de 6 meses
                echo '<script>alert("ERROR AL BUSCAR!, el rango de busqueda debe comenzar despues de los 6 meses desde la fecha actual.");
                    window.location = "buscar.php";</script>';
            }

            //aca se chequea que el rango de busqueda no supere los dos meses
            $fh = date("d-m-Y",strtotime($fechaHasta));
            $fechaDesdeAux2 = date("d-m-Y",strtotime($fechaDesde));
            $fechaDesdeAux = date("d-m-Y",strtotime($fechaDesde."+ 1 months"));
            

            if (($fechaDesdeAux == $fh) OR ($fechaDesdeAux2 == $fh)) {//deben ser el mismo mes
                
                $query= "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.inicia, s.periodo, r.id AS idResi, s.id AS idSubasta FROM residencia r
                INNER JOIN subasta s ON r.id = s.id_residencia
                WHERE date_format(s.periodo, '%Y-%m') BETWEEN '$fechaDesde' AND '$fechaHasta' ORDER BY ubicacion";
                $resultado = mysqli_query($conexion, $query);  
            }
            else{
                echo "<script>alert('ERROR AL BUSCAR!, no se puede buscar en un rango mayor de los 2 meses.');
                    window.location = 'buscar.php';</script>";
            }
        }
        else if (!$_GET['ubicacion']==""){
            $fechaDesde= $_GET['fechaDesde'];
            $fechaHasta= $_GET['fechaHasta'];
            $ubicacion= $_GET['ubicacion'];

            $fd = date("d-m-Y",strtotime($fechaDesde));
            $fh = date("d-m-Y",strtotime($fechaHasta));

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $zonahoraria = date_default_timezone_get();
            @$fecha_actual=date("d-m-Y",time());//Establesco la fecha y hora de Bs.As


            //aca se chequea que sea una busqueda valida
            if ($fd > $fh) {//no tendria sentido esta busqueda
                echo '<script>alert("RANGO DE BUSQUEDA NO VALIDO!, el mes inicial debe ser menor o igual al mes final.");
                    window.location = "buscar.php";</script>';
            }

            $fecha_actual = date("m-Y",strtotime($fecha_actual));
            $fd = date("m-Y",strtotime($fechaDesde));

            if ($fecha_actual > $fd) {//si realiza un busqueda con valores inferior al mes actual
                echo '<script>alert("ERROR AL BUSCAR!, el mes de inicio del rango debe ser igual o mayor al mes actual.");
                    window.location = "buscar.php";</script>';
            }

            //le aumento 6 meses a la fecha actual
            $fecha_actual = date("d-m-Y",strtotime($fecha_actual."+ 6 months"));

            //cambio el formato de la fecha actual para que no muestre los dias
            $fecha_actual = date("m-Y",strtotime($fecha_actual));
            $fh = date("m-Y",strtotime($fechaHasta));


            //aca se chequea que el mes superior de busqueda no supere los 6 meses
            if ($fh > $fecha_actual) {//si sobrepasa los 6 meses
                echo '<script>alert("ERROR AL BUSCAR!, no se puede buscar en un rango mayor de los 6 meses desde el mes actual.");
                    window.location = "buscar.php";</script>';
            }

            //aca se chequea que el rango de busqueda no supere los dos meses
            $fh = date("d-m-Y",strtotime($fechaHasta));
            $fechaDesdeAux2 = date("d-m-Y",strtotime($fechaDesde));
            $fechaDesdeAux = date("d-m-Y",strtotime($fechaDesde."+ 1 months"));

            if (($fechaDesdeAux == $fh) OR ($fechaDesdeAux2 == $fh)) {
                $query= "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_inicial, s.puja_ganadora, s.inicia, s.periodo, r.id AS idResi, s.id AS idSubasta FROM residencia r
                INNER JOIN subasta s ON r.id = s.id_residencia
                WHERE (date_format(s.periodo, '%Y-%m') BETWEEN '$fechaDesde' AND '$fechaHasta') AND (r.ubicacion = '$ubicacion')";
                $resultado = mysqli_query($conexion, $query);  
            }
            else{
                echo "<script>alert('ERROR AL BUSCAR!, no se puede buscar en un rango mayor de los 2 meses.');
                    window.location = 'buscar.php';</script>";
            }     
     */   }    
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
                              <label for="disabledTextInput">Inicio del rango de busqueda</label>
                              <input type="month" id="disabledTextInput" class="form-control" name="fechaDesde" value="<?php echo $fechaDesde;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledTextInput">Fin del rango de busqueda</label>
                              <input type="month" id="disabledTextInput" class="form-control" name="fechaHasta" value="<?php echo $fechaHasta;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledSelect">Ubicación</label>
                              <input type="text" id="disabledSelect" class="form-control" name="ubicacion" value="" placeholder="">
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                           
                        </form>
                    </div>
                    <div class="col-sm-4 text-right">
                                <h2><a href="index.php"><b>HSH</b></a></h2>
                            </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nro de subasta</th>
                        <th>Nombre</th>
                        <th>Portada</th>
                        <th>Fecha y Hora de Inicio</th>
                        <th>Ubicación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['idResi'];$j++;
                            
                            $fechaInicio = $fila['inicia'];
                            $fecha = date("d-m-Y",strtotime($fechaInicio));
                            $hora = date("H:i",strtotime($fechaInicio));
                    ?>
                    <tr>
                        <td><?php echo $id;?></td>
                        <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                        <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                        <td><?php echo  "El ".$fecha." a las ".$hora;?></td>
                        <td><?php echo utf8_encode(utf8_decode($fila['ubicacion']));?></td>
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