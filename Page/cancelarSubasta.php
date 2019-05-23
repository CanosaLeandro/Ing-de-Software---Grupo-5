<?php
    Include("DB.php");
    $conexion = conectar();
    $idSubasta = $_GET['id'];
    $query = "SELECT id_residencia FROM subasta s INNER JOIN residencia r ON r.id = s.id_residencia WHERE s.id = $idSubasta";
    $resultado = mysqli_query($conexion, $query);
    if(mysqli_query($conexion,"DELETE FROM subasta WHERE id = $idSubasta")){
        if(!(mysqli_num_rows($resultado) > 1)){
            if(mysqli_query($conexion,"UPDATE residencia SET en_subasta='no' WHERE id = $idSubasta"))
            
                echo '<script>alert("La propiedad fue eliminada del sistema.");
                        window.location = "subastas.php"; </script>';
        }
    }
    else{ echo '<script>alert("La subasta no pudo cancelarse, intentelo en otro momento.");
        window.location = "subastas.php"; </script>';
    }
?>