<?php
    Include("DB.php");
    $conexion = conectar();
    $ID = $_POST['idS'];
    $monto = $_POST['monto'];
    if(mysqli_query($conexion,"UPDATE subasta SET puja_ganadora= $monto WHERE ID = $ID")){
?>
            <script> alert("La operación se completo correctamente");
                window.location = "subasta.php?id="+<?php echo($ID); ?> ;
            </script>
<?php
    }else {
?>
            <script> alert("No se pudo agregar el registo al sistema.");
                window.location = "subasta.php?id="+<?php echo($ID); ?> ;
            </script>
<?php
    }
?>