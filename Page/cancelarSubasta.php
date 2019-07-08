<?php
    Include("DB.php");
    $conexion = conectar();
    $idSubasta = $_GET['id'];
    
    //consulta por la semana de la subasta
    $querySemana = "SELECT * FROM subasta WHERE id = $idSubasta";
    $sqlSemana = mysqli_query($conexion, $querySemana);
    $result = mysqli_fetch_assoc($sqlSemana);
    $semana = $result['id_semana'];
    
    //elimino la subasta
    if(mysqli_query($conexion,"DELETE FROM subasta WHERE id = $idSubasta")){
        
        //actualizo el estado de la semana
        if(mysqli_query($conexion,"UPDATE semana SET disponible = 'si' , en_subasta = 'no' WHERE id = $semana")){
            
            //pregunta si la residencia tiene mas de una subasta activa
            if((mysqli_num_rows($sqlSemana) == 1)){
                
                //al no tener mas subastas le actualiza el estado de la residencia
                if(mysqli_query($conexion,"UPDATE residencia SET en_subasta='no' WHERE id = $idSubasta")){
                    echo '<script>alert("la subasta fue cancelada con éxito.");
                        window.location = "crudResidencia.php"; </script>';
                }
                else{ echo '<script>alert("Subasta cancelada con éxito. 
                    Error al actualizar el estado de la residencia.");
                    window.location = "crudResidencia.php"; </script>';
                }
            }else{
                echo '<script>alert("la subasta fue cancelada con éxito.");
                        window.location = "crudResidencia.php"; </script>';
            }
        }
        else{ echo '<script>alert("Error al actualizar la semana, intentelo en otro momento.");
            window.location = "crudResidencia.php"; </script>';
        }   
    }
    else{ echo '<script>alert("La subasta no pudo cancelarse, intentelo en otro momento.");
        window.location = "crudResidencia.php"; </script>';
    }
?>