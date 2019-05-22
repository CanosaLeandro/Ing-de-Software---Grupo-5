<?php
    Include("DB.php");
    $conexion = conectar();
    $ID = $GET['id'];
    $monto = $_POST['monto'];
    if(mysqli_query($conexion,"UPDATE subasta SET puja_ganadora= $monto WHERE ID = $ID")){
            echo '<script> alert("La operación se completo correctamente");
            window.location = "subasta.php";</script>';
        }else{ echo '<script> alert("No se pudo agregar el registo al sistema.");
            window.location = "subasta.php";</script>';
    }   
    ?>



