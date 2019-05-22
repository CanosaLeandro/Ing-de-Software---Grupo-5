<?php
    Include("DB.php");
    $conexion = conectar();

    $ID = $_POST['idS'];
    $monto = $_POST['monto'];

    $qryPuja = "SELECT puja_ganadora FROM subasta WHERE puja_ganadora = $ID";
    $result = mysqli_query($conexion, $qryPuja);
    $pujaActual = mysqli_fetch_assoc($result)['puja_ganadora'];

    if($pujaActual < $monto) {
        if(mysqli_query($conexion,"UPDATE subasta SET puja_ganadora= $monto WHERE ID = $ID")){
?>
            <script> alert("La operación se completo correctamente");
                window.location = "subastas.php" ;
            </script>
    <?php
        }else {
    ?>  
        <script> alert("No se pudo agregar el registo al sistema.");
                window.location = "subasta.php?id="+<?php echo($ID); ?> ;
        </script>
<?php
        }     
    }else {
?>
    <script> alert("ERROR!. El monto no supera la puja actual."); 
            window.location = "subasta.php?id="+<?php echo($ID); ?> ;
    </script>
<?php
    }
?>