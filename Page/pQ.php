<?php
    Include("DB.php");
    $conexion = conectar();
    $idPuja = 4;
    $query = "SELECT monto FROM puja WHERE id=".$idPuja;
    $res = mysqli_query($conexion, $query); 
    $filas = mysqli_fetch_assoc($res);
    echo ( $filas['monto']);
?>