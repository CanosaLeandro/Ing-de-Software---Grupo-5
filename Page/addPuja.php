<?php
    Include("DB.php");
    $conexion = conectar();

    $IDS = $_POST['idS'];
    $monto = $_POST['monto'];

    $qry = "SELECT monto, puja_ganadora FROM subasta s INNER JOIN puja p ON s.puja_ganadora = p.id WHERE s.id =".$IDS;
    $result = mysqli_query($conexion, $qry);
    $registros = mysqli_fetch_assoc($result);
    $pujaGanadora = $registros['puja_ganadora'];
    $montoActual = $registros['monto'];

    if($montoActual < $monto) {
        if(mysqli_query($conexion,"INSERT INTO puja SET id_usuario=1, id_subasta=$IDS, monto=$monto") &&
            mysqli_query($conexion, "UPDATE subasta SET puja_ganadora= $pujaGanadora WHERE id = $IDS")){
?>
                <script> alert("La operación se completo correctamente");
                    window.location = "subastas.php?id="+<?php echo($IDS); ?>
                </script>
    <?php 
            } else {
    ?> 
                <script> alert("ERROR!. La operacion no pudo realizarse"); 
                    window.location = "subasta.php?id="+<?php echo($IDS); ?> ;
                </script>
    <?php
            }
    } else {
    ?>
    <script> alert("ERROR!. El monto no supera la puja actual."); 
            window.location = "subasta.php?id="+<?php echo($IDS); ?> ;
    </script>
<?php
    }
?>