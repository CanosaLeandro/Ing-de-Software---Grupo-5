<?php
    Include("DB.php");
    $conexion = conectar();
    
    $fechaInicio = $_POST['inicia'];
    $fechaPeriodo = $_POST['periodo'];
    $diferenciaDias = ($fechaInicio - $fechaPeriodo) / 86400;
        
        //Caclculo la diferencia en meses
    if( ceil($diferenciaDias / 30,417)  > 6 ){
        
    }
?>