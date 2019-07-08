<!DOCTYPE html>
<html lang="es">
<?php
    Include("DB.php");
    $conexion = conectar();             
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busqueda de subastas</title>
    <link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_crudResidencia.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
      require('links.php');
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php 

//Esta parte es el buscador
if(isset($_GET['buscar'])){
 
    $fechaDesde= $_GET['fechaDesde'];
    $fechaHasta= $_GET['fechaHasta'];

    $diaFD = substr($fechaDesde,8,2);
    $mesFD = substr($fechaDesde,5,2);
    $anioFD = substr($fechaDesde,0,4);
    $semanaFD = date('W',  mktime(0,0,0,$mesFD,$diaFD,$anioFD));

    //PARA EL DIA DE FECHA DE INICIO
    switch ($diaFD) {
        case '01':
            $diaFD=1;
            break;
        case '02':
            $diaFD=2;
            break;
        case '03':
            $diaFD=3;
            break;
        case '04':
            $diaFD=4;
            break;
        case '05':
            $diaFD=5;
            break;
        case '06':
            $diaFD=6;
            break;
        case '07':
            $diaFD=7;
            break;
        case '08':
            $diaFD=8;
            break;
        case '09':
            $diaFD=9;
            break;
    }

    //PARA EL MES DE FECHA DE INICIO
    switch ($mesFD) {
        case '01':
            $mesFD=1;
            break;
        case '02':
            $mesFD=2;
            break;
        case '03':
            $mesFD=3;
            break;
        case '04':
            $mesFD=4;
            break;
        case '05':
            $mesFD=5;
            break;
        case '06':
            $mesFD=6;
            break;
        case '07':
            $mesFD=7;
            break;
        case '08':
            $mesFD=8;
            break;
        case '09':
            $mesFD=9;
            break;
    }

    $diaFH   = substr($fechaHasta,8,2);
    $mesFH = substr($fechaHasta,5,2);
    $anioFH = substr($fechaHasta,0,4);
    $semanaFH = date('W',  mktime(0,0,0,$mesFH,$diaFH,$anioFH));

    //PARA EL DIA DE FECHA DE FIN
    switch ($diaFH) {
        case '01':
            $diaFH=1;
            break;
        case '02':
            $diaFH=2;
            break;
        case '03':
            $diaFH=3;
            break;
        case '04':
            $diaFH=4;
            break;
        case '05':
            $diaFH=5;
            break;
        case '06':
            $diaFH=6;
            break;
        case '07':
            $diaFH=7;
            break;
        case '08':
            $diaFH=8;
            break;
        case '09':
            $diaFH=9;
            break;
    }

    //PARA EL MES DE FECHA DE FIN
    switch ($mesFH) {
        case '01':
            $mesFH=1;
            break;
        case '02':
            $mesFH=2;
            break;
        case '03':
            $mesFH=3;
            break;
        case '04':
            $mesFH=4;
            break;
        case '05':
            $mesFH=5;
            break;
        case '06':
            $mesFH=6;
            break;
        case '07':
            $mesFH=7;
            break;
        case '08':
            $mesFH=8;
            break;
        case '09':
            $mesFH=9;
            break;
    }

    //obtengo todas las semana del rango buscado
    //todavia me falta chequear el año

    //esta es la consulta que tengo que hacer, mas o menos
    $query="SELECT * FROM semana WHERE ((num_semana BETWEEN '$semanaFD' AND '$semanaFH') AND (anio BETWEEN '$anioFD' AND '$anioFH') AND (en_subasta='si'))";

    $resultado = mysqli_query($conexion, $query);

    if ($_GET['ubicacion']==""){//si no busco por ubicacion
        $buscoPorUbicacion=false;
    }//FIN DEL IF DE BUSQUEDA SIN UBICACION
    else{//Si busco tambien por ubicacion
        $ubicacion= $_GET['ubicacion'];
        $buscoPorUbicacion=true;
    }
                  
}//FIN DEL IF QUE CHEQUEA SI BUSCO

date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();
@$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.

$fechaAux = date("Y-m-d",strtotime($fecha_actual."+ 6 months"));
?>
<body>
<div style="margin-top: -100px;" class="site-wrap">
    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    <div class="site-navbar-wrap js-site-navbar bg-white">
      
      <div style="background-image: url('images/hero_1.jpg');" class="container-fluit">
        <div style="margin-top: -24px;" class="site-navbar bg-light">
          <div style="background-image: url('images/hero_1.jpg');" class="py-1">
            <div style="background-image: url('images/hero_1.jpg');" class="row align-items-center">
              <div class="col-2">
                <a class="navbar-brand" href="index.php">
                    <img style="margin-top: -40px;" src="Logos/Logos/HSH-Complete.svg" width="100" height="100" class="d-inline-block align-top" alt="">
                  </a>
              </div>
              <div class="col-10">
                <nav style="background-image: url('images/hero_1.jpg');" class="site-navigation text-right" role="navigation">
                  <div class="container-fluit">
                    
                    <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>
                    <ul style="" class="site-menu js-clone-nav d-none d-lg-block">
                      <li class="has-children">
                        <a style="color:black;">Buscar Residencias</a>
                        <ul class="dropdown arrow-top">
                          <li><a href="buscarUbicacion.php">Buscar por ubicacion</a></li>
                          <li><a href="buscarDescripcion.php">Buscar por descripción</a></li>
                        </ul>
                      </li>
                      <li><a style="color:black;" href="hotsales.php">Hotsale</a></li>
                      <li><a style="color:black;" href="subastas.php">Subastas</a></li>
                      <li>
                        <div >
                          <a href="" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <b style="color:black;"> Mi HSH </b>
                          </a>
                          <div style="cursor: pointer;" class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a href="listaReservas.php" class="dropdown-item enlaceEditar">Reservas realizadas</a>
                            <a href="listarPujas.php" class="dropdown-item enlaceEditar">Ver mis pujas</a>
                            <a href="editModalUser.php" class="dropdown-item enlaceEditar">Editar cuenta</a>
                            <a href="deleteUser.php?id=<?php echo $id; ?>" class="dropdown-item enlaceEditar">Borrar cuenta</a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item enlaceEditar" >Cerrar sesión</a>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


</div>



    <div style="margin-top: 100px;"  class="container">
        <div style="margin-top: 100px;"  class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>Buscar <b>Subastas</b></h2>
                    </div>

                    <!-- buscador por rangos de fechas -->
                    <div class="col-sm-4">
                        <form action="buscadorSubasta.php" method="GET">
                            <div class="form-group">
                              <label for="disabledTextInput">Inicio del rango de busqueda</label>
                              <input type="date" id="disabledTextInput" class="form-control" name="fechaDesde" value="<?php echo $fechaDesde;?>" min="<?php echo $fechaAux;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledTextInput">Fin del rango de busqueda</label>
                              <input type="date" id="disabledTextInput" class="form-control" name="fechaHasta" value="<?php echo $fechaHasta;?>" min="<?php echo $fechaAux;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledSelect">Ubicación</label>
                              <input type="text" id="disabledSelect" class="form-control" name="ubicacion" value="" placeholder="">
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                           
                        </form>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nro de subasta</th>
                        <th>Nombre</th>
                        <th>Portada</th>
                        <th>Fecha y Hora de Inicio</th>
                        <th>Ubicación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  


                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $idSemana=$fila['id'];
                            //por cada idSemana busco la subasta correspondiente
                            if ($buscoPorUbicacion) {
                                $querySubasta="SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_minimo, s.puja_ganadora, s.inicia, s.id_semana, r.id AS idResi, s.id AS idSubasta FROM residencia r INNER JOIN subasta s ON r.id = s.id_residencia WHERE (id_semana=$idSemana AND r.ubicacion='$ubicacion')";
                            }else{
                                $querySubasta="SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_minimo, s.puja_ganadora, s.inicia, s.id_semana, r.id AS idResi, s.id AS idSubasta FROM residencia r INNER JOIN subasta s ON r.id = s.id_residencia WHERE id_semana=$idSemana";
                            }
                            $resultadoSubasta = mysqli_query($conexion, $querySubasta);
                            $numrows=mysqli_num_rows($resultadoSubasta);
                            if($numrows!=0){
                   
                                $arraySubasta=mysqli_fetch_assoc($resultadoSubasta);

                                $id = $arraySubasta['idResi']; $j++;
                                $idSubasta=$arraySubasta['idSubasta'];
                                
                                $fechaInicio = $arraySubasta['inicia'];
                                $fecha = date("d-m-Y",strtotime($fechaInicio));
                                $hora = date("H:i",strtotime($fechaInicio));
                                echo "
                                <tr>
                                    <td>".$id."</td>
                                    <td>".utf8_encode(utf8_decode($arraySubasta['nombre']))."</td>
                                    <td><img class='foto' src='foto.php?id= $id'/></td>
                                    <td>El $fecha a las $hora</td>
                                    <td> ".utf8_encode(utf8_decode($arraySubasta['ubicacion']))."</td>
                                    <td>
                                        <a href='subasta.php?id=$idSubasta'><button type='button' class='btn btn-info'><span>Ver Subasta</span></button></a>
                                    </td>
                                </tr> ";
                            }
                            

                 
                    
                    };
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>

  
  <script src="js/mediaelement-and-player.min.js"></script>

  <script src="js/main.js"></script>

</html>                                                                 