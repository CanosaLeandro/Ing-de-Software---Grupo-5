<?php
    Include("DB.php");
    $conexion = conectar();
    $idSubasta = $_GET['id'];
    ##############################################
    #necesita arreglos y testeo
    ##############################################
    
    //consulta por la semana de la subasta
    $querySemana = "SELECT id_semana FROM subasta WHERE id = $idSubasta";
    $sqlSemana = mysqli_query($conexion, $querySemana);
    $result = mysqli_fetch_assoc($sqlSemana);
    $semana = $result['id_semana'];
    
    //actualizo el estado de la semana
    if(mysqli_query($conexion,"UPDATE semana SET activa = 'si' AND en_subasta='no' WHERE id = $semana")){
        
        //consulta por la subasta
        $query = "SELECT * FROM subasta s INNER JOIN residencia r ON r.id = s.id_residencia";
        $sqlSubasta = mysqli_query($conexion, $query);
        $resultadoSubasta = mysqli_fetch_assoc($sqlSubasta);

        
        //elimino la subasta
        if(mysqli_query($conexion,"DELETE FROM subasta WHERE id = $idSubasta")){        
            
            //pregunta si la residencia tiene mas de una subasta activa
            if(!(mysqli_num_rows($resultadoSubasta) > 1)){
                
                //al no tener mas subastas le actualiza el estado de la residencia
                if(mysqli_query($conexion,"UPDATE residencia SET en_subasta='no' WHERE id = $idSubasta")){
                    echo '<script>alert("la subasta fue cancelada con éxito.");
                        window.location = "crudResidencia.php"; </script>';
                }
                else{ echo '<script>alert("Subasta cancelada con éxito. 
                    Error al actualizar el estado de la residencia.");
                    window.location = "crudResidencia.php"; </script>';
                }   
            }
        }
        else{ echo '<script>alert("La subasta no pudo cancelarse, intentelo en otro momento.");
            window.location = "crudResidencia.php"; </script>';
        }   
    }
    else{ echo '<script>alert("Error al actualizar la semana, intentelo en otro momento.");
        window.location = "crudResidencia.php"; </script>';
    }
?>