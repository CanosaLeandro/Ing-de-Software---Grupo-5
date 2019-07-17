<?php
    Include("DB.php");
    $conexion = conectar();

    /*aca valida si inicio sesion--------------------------------------------*/
    require_once('Authentication.php');
    $authentication = new Authentication(); 
    $authentication->login();                       
    try{                
        $authentication->logueadoAdmin();
    }catch(Exception $ex){
        $error = $ex->getMessage();
        echo "<script>alert('$error');</script>";
        echo "<script>window.location = 'loginAdmin.php';</script>";
    }
    /*---------------------------------------------------------------------------*/
    $idRes = $_POST['idResidencia'];
    $precio = $_POST['precio'];
    $idSemana = $_POST['semana'];


    //En caso de que alguna query a la base de datos falle
    function errQuery(){
        global $idRes;
        echo('<script> alert("ERROR!. La consulta falló"); 
               window.location(formularioCrearHotsale.php?id='.$idRes.');
            </script>');
    }

    //Errores 
    function errorQuery($mensaje){
        global $idRes;
        echo('<script> alert("ERROR!. '.$mensaje.'"); 
                window.location(formularioCrearHotsale.php?id='.$idRes.');
            </script>');
    }
     

    //Sin errores
    function success(){
        global $idRes;
        echo ('<script> alert("El Hotsale se creó correctamente"); 
                    window.location = "crearHotsale.php";
                </script>');
    }
    
 //Inserto el nuevo hotsale
 if(mysqli_query($conexion, "INSERT INTO hotsale
                             (id,id_residencia,precio,id_semana,activo) VALUES (NULL,$idRes,$precio,$idSemana,'si')")){

     //Deshabilito la semana que se puso en hotsale
     if(mysqli_query($conexion, "UPDATE semana SET disponible = 'no', en_hotsale='si' WHERE id=$idSemana")){ 
        if(mysqli_query($conexion, "UPDATE residencia SET en_hotsale='si' WHERE id=$idRes")){                
            success();
        }
     } else{
         errorQuery('Error al actualizar la semana a reservada');
     }
 } else {
     errorQuery('Error al crear la Hotsale.');
 }
             
?>