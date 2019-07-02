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
    $IDS = $_POST['idS'];//id de la subasta
    //$tienePujas es una variable booleana
    $monto = $_POST['monto'];

    if(mysqli_query($conexion,"INSERT INTO puja SET id_usuario = $idUser, id_subasta = $IDS, monto = $monto")){
        $rs = mysql_query("SELECT @@identity AS id");//obtengo el id de la puja recien insertada
        if ($row = mysql_fetch_row($rs)) {
        $idPuja = trim($row[0]);//id de la puja
        }
        if(mysqli_query($conexion, "UPDATE subasta SET puja_ganadora= $idPuja WHERE id = $IDS")){

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