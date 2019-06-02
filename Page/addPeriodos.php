<?php
    function calcularPeriodos($idRes ,$conexion) {
        $ok = TRUE;
        $date = date("Y-m-d H:i:s");
        while ($date <  date("Y-m-d H:i:s", strtotime('Dec 31')) && $ok) {
            $qry = "INSERT INTO periodo 
                    SET id_residencia = $idRes, fecha = '$date'";
            
            if( !(mysqli_query($conexion, $qry) ) ){
                   
                $ok = FALSE;
            } else {
                echo ('hola'); 
            }
            $date = date("Y-m-d H:i:s", strtotime($date.'+ 6 days'));   
        }
    }
?>