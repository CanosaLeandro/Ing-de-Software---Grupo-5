<?php
    Include("DB.php");
    $conexion = conectar();

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
    $verificar=mysqli_query($conexion,"SELECT * FROM reserva WHERE id_usuario=$idUser AND semana=$idPeriodo"); 
    if(mysqli_num_rows($verificar)!=0){
        echo '<script>alert("¡ERROR, usted no puede realizar esta puja porque ya tiene una reserva para la semana subastada!");
        window.location="subasta.php?id='.$IDS.'";</script>';
    }else{
        //averiguo si tiene creditos para realizar la puja
        $sqlCreditos=mysqli_query($conexion,"SELECT creditos FROM usuario WHERE id = $idUser");
        $result=mysqli_fetch_assoc($sqlCreditos);
        $creditos=$result['creditos'];
        if ($creditos==0) {
            echo '<script>alert("¡ERROR, usted no tiene creditos disponibles para participar de esta subasta");
                 window.location="subasta.php?id='.$IDS.'";</script>';
        }
        else{//si tiene creditos, entonces puede pujar

            if(mysqli_query($conexion,"INSERT INTO puja SET id_usuario = $idUser, id_subasta = $IDS, monto = $monto")){
                $rs = mysqli_query($conexion,"SELECT @@identity AS id");//obtengo el id de la puja recien insertada
                if ($row = mysqli_fetch_row($rs)) {
                     $idPuja = trim($row[0]);//id de la puja
                }
                if(mysqli_query($conexion, "UPDATE subasta SET puja_ganadora= $idPuja WHERE id = $IDS")){

                    echo"<script>alert('La operación se completo correctamente');
                        window.location='subasta.php?id=$IDS';</script>";

                } else {

                   echo"<script> alert('ERROR. No pudo realizarse la puja, intente en otro momento.');
                        window.location ='subasta.php?id=$IDS';</script>";

                }
            } else{

                 echo"<script> alert('ERROR. No se actualizo la subasta.');
                        window.location ='subasta.php?id=$IDS';</script>";

            }

        }
    }



    

    








/*

    $qry = "SELECT monto, puja_ganadora FROM subasta s INNER JOIN puja p ON s.puja_ganadora = p.id WHERE s.id =".$IDS;
    $result = mysqli_query($conexion, $qry);
    $registros = mysqli_fetch_assoc($result);
    $pujaGanadora = $registros['puja_ganadora'];
    $montoActual = $registros['monto'];
*/
   /* if($montoActual < $monto) {*/
        /*if(mysqli_query($conexion,"INSERT INTO puja SET id_usuario = $idUser, id_subasta = $IDS, monto = $monto")){
            if(mysqli_query($conexion, "UPDATE subasta SET puja_ganadora= $pujaGanadora WHERE id = $IDS")){
   
                echo"<script> alert('La operación se completo correctamente');
                    window.location ='subasta.php?id='".$IDS."'; ?>
                </script>";

            } else {
   
               echo"<script> alert('ERROR. No pudo realizarse la puja, intente en otro momento.');
                    window.location ='subasta.php?id='".$IDS."'; ?>
                </script>";
  
            }
        } else{
    
             echo"<script> alert('ERROR. No se actualizo la subasta.');
                    window.location ='subasta.php?id='".$IDS."'; ?>
                </script>";
 
        }*/
    /*} else {*/
    ?>
    <!-- <script> alert("ERROR!. El monto no supera la puja actual."); 
            window.location = "subasta.php?id="+<?php echo($IDS); ?> ;
    </script> -->
<?php
    
?>