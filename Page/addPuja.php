<?php
    Include("DB.php");
    $conexion = conectar();

    $ID = $_POST['idS'];
    $monto = $_POST['monto'];

    $qryPuja = "SELECT puja_ganadora FROM subasta WHERE id =".$ID;
    $result = mysqli_query($conexion, $qryPuja);
    $pujaActual = mysqli_fetch_assoc($result)['puja_ganadora'];
    
    $qryActual = "SELECT monto FROM puja WHERE id = $pujaActual";
    $resulta2 = mysqli_query($conexion, $qryActual);
    $montoActual = mysqli_fetch_assoc($resulta2)['monto'];

    if($montoActual < $monto) {
        if(mysqli_query($conexion,"INSERT INTO puja VALUES ( , ,1, $ID , $monto )")){
            $qryLastPuja = "SELECT id FROM puja WHERE monto = $monto";
            $resultado = mysqli_query($conexion,$qryLastPuja);
            $lastPuja = mysqli_fetch_assoc($resulatdo)['id'];
            if (mysqli_query($conexion,"UPDATE subasta SET puja_ganadora= $lastPuja WHERE ID = $ID")){
                ?>
                <script> alert("La operación se completo correctamente");
                    window.location = "subastas.php?id="+<?php echo($ID); ?>
                </script>
        <?php 
            }
        } else {
        ?>  
        <script> alert("No se pudo agregar el registo al sistema.");
                window.location = "subasta.php?id="+<?php echo($ID); ?> ;
        </script>
<?php
        }     
    } else {
?>
    <script> alert("ERROR!. El monto no supera la puja actual."); 
            window.location = "subasta.php?id="+<?php echo($ID); ?> ;
    </script>
<?php
    }
?>