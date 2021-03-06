<?php
    Include("DB.php");
    $conexion = conectar();
    Include("calcularCreditos.php");

    /*aca valida si inicio sesion--------------------------------------------*/
    require_once('Authentication.php');
    $authentication = new Authentication(); 
    $authentication->login();                       
    try{                
        $authentication->logueado();
    }catch(Exception $ex){
        $error = $ex->getMessage();
        echo "<script>alert('$error');</script>";
        echo "<script>window.location = 'home.php';</script>";
    }       

    /*----------------------------------------------------------------------------*/


    $idUser= $_SESSION['id'];//id del usuario
    $idPeriodo=$_POST['idP'];//id del periodo
    $IDS = $_POST['idS'];//id de la subasta
    //$tienePujas es una variable booleana
    $monto = $_POST['monto'];
    //verifico que el usuario tenga la semana de la subasta libre
    $queryPeriodo="SELECT * FROM semana WHERE id = $idPeriodo";
    $resutPeriodo=mysqli_query($conexion,$queryPeriodo);
    $arrayPeriodo=mysqli_fetch_assoc($resutPeriodo);
    //obtengo la semana y el año de la semana subastada para comparar luego 
    $semanaPeriodo=$arrayPeriodo['num_semana'];
    $anioPeriodo=$arrayPeriodo['anio'];
    $creditos = calcularCreditos($idUser,$anioPeriodo);
    if ($creditos==0) {
        echo '<script>alert("¡ERROR, usted no tiene creditos disponibles para participar de esta subasta");
             window.location="subasta.php?id='.$IDS.'";</script>';
    }
    elseif($creditos>0){//si tiene creditos, entonces compruebo la semana si esta disponible
        //obtengo todas las reservas y hotsales del usuario
        $verificar=true;
        $queryReservas="SELECT id_semana FROM reserva WHERE id_usuario=$idUser
        UNION DISTINCT
        SELECT id_semana FROM hotsalecomprados INNER JOIN hotsale ON hotsalecomprados.id_hotsale = hotsale.id 
        WHERE  id_usuario=$idUser";
        $resultReservas=mysqli_query($conexion,$queryReservas);
        while ($row=mysqli_fetch_assoc($resultReservas)) {
            $idPeriodoReserva=$row['id_semana'];
            $queryPeriodoReserva="SELECT * FROM semana WHERE id = $idPeriodoReserva";
            $resutPeriodoReserva=mysqli_query($conexion,$queryPeriodoReserva);
            $arrayPeriodoReserva=mysqli_fetch_assoc($resutPeriodoReserva);
            $semanaPeriodoReserva=$arrayPeriodoReserva['num_semana'];
            $anioPeriodoReserva=$arrayPeriodoReserva['anio'];
            //verifico si es la misma semana y el misma año
            if (($semanaPeriodo==$semanaPeriodoReserva)&&($anioPeriodo==$anioPeriodoReserva)) {
                echo '<script>alert("Error, usted ya tiene una reserva para esa semana, intente con otra.");
                    window.location="hotsales.php";</script>';
                $verificar=false;
            }

        }
    
        if($verificar){

                if(mysqli_query($conexion,"INSERT INTO puja SET id_usuario = $idUser, id_subasta = $IDS, monto = $monto")){
                    $rs = mysqli_query($conexion,"SELECT @@identity AS id");//obtengo el id de la puja recien insertada
                    if ($row = mysqli_fetch_row($rs)) {
                        $idPuja = trim($row[0]);//id de la puja
                    }
                    if(mysqli_query($conexion, "UPDATE subasta SET puja_ganadora= $idPuja WHERE id = $IDS")){

                        echo"<script>alert('Puja realizada con éxito');
                            window.location='subasta.php?id=$IDS';</script>";

                    } else {

                    echo"<script> alert('ERROR. No pudo realizarse la puja, intente en otro momento.');
                            window.location ='subasta.php?id=$IDS';</script>";

                    }
                } else{

                    echo"<script> alert('ERROR. No se actualizo la subasta.');
                            window.location ='subasta.php?id=$IDS';</script>";

                }

            }else{
                echo"<script> alert('ERROR. La cantidad de créditos es erronea. Consulatar con el administrador');
                            window.location ='subasta.php?id=$IDS';</script>";
            }
        }

?>