<!DOCTYPE html>
<html lang="es">
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

//cantidad de registros por pagina
$por_pagina = 4;

//si se presiono algun indice de la paginacion
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];

    $fechaDesde= $_GET['fechaDesde'];
    $fechaHasta= $_GET['fechaHasta'];
    
    $diaFD = substr($fechaDesde,8,2);
    $mesFD = substr($fechaDesde,5,2);
    $anioFD = substr($fechaDesde,0,4);
    $semanaFD = date('W',  mktime(0,0,0,$mesFD,$diaFD,$anioFD));

}else{
    $pagina = 1;
}

$arrayMatriz=NULL;
$empieza = ($pagina - 1) * $por_pagina;

//Esta parte es el buscador
if(isset($_GET['buscar'])){

    $fechaDesde= $_GET['fechaDesde'];
    $fechaHasta= $_GET['fechaHasta'];

    $diaFD = substr($fechaDesde,8,2);
    $mesFD = substr($fechaDesde,5,2);
    $anioFD = substr($fechaDesde,0,4);
    $semanaFD = date('W',  mktime(0,0,0,$mesFD,$diaFD,$anioFD));

}//FIN DEL IF QUE CHEQUEA SI BUSCO

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

//aca chequeo que la fecha de inicio no sea mayor a la fecha de fin
if ($anioFD==$anioFH) {
    if ($mesFD==$mesFH) {
        if ($diaFD>$diaFH) {
            echo "<script>alert('Error al buscar, la fecha de inicio no puede ser mayor a la de fin.');
            window.location='buscar.php';</script>";
        }
    }elseif ($mesFD>$mesFH) {
        echo "<script>alert('Error al buscar, la fecha de inicio no puede ser mayor a la de fin.');
            window.location='buscar.php';</script>";
    }
}elseif ($anioFD>$anioFH) {
    echo "<script>alert('Error al buscar, la fecha de inicio no puede ser mayor a la de fin.');
            window.location='buscar.php';</script>";
}

//chequeo que no se supere el rango de busqueda
if ($anioFD==$anioFH) {//si es el mismo año
    //9 semanas casi igual a 2 meses
    if (($mesFH-$mesFD)>2) {//rango de 2 meses superado
        echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
            window.location='buscar.php';</script>";
    }elseif (($mesFH-$mesFD)==2) {
        if ($diaFH>$diaFD) {    
            echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
            window.location='buscar.php';</script>";
        }
    }
}else{//si el año es distinto
    $mesFin=($mesFH+12);
    if (($mesFin-$mesFD)>2) {
        echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
                window.location='buscar.php';</script>";
    }elseif (($mesFin-$mesFD)==2) {
        if ($diaFH>$diaFD) {    
            echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
            window.location='buscar.php';</script>";
        }
    }
}

//obtengo todas las semana del rango buscado
$query="SELECT * FROM semana WHERE ((num_semana BETWEEN '$semanaFD' AND '$semanaFH') AND (anio BETWEEN '$anioFD' AND '$anioFH') AND (en_subasta='si')) ORDER BY id LIMIT $empieza, $por_pagina ";
$resultado = mysqli_query($conexion, $query);

//esta query es para la paginacion sin busqueda de localidad
$queryr="SELECT * FROM semana WHERE ((num_semana BETWEEN '$semanaFD' AND '$semanaFH') AND (anio BETWEEN '$anioFD' AND '$anioFH') AND (en_subasta='si'))";
$resultador = mysqli_query($conexion, $queryr);
$num=mysqli_num_rows($resultador);
//$num tiene la cantidad de registros para paginar sino busco por ubicacion


if ($_GET['ubicacion']==''){//si no busco por ubicacion
    $ubicacion='';
    $buscoPorUbicacion=false;
}else{//Si busco tambien por ubicacion
    $ubicacion=$_GET['ubicacion'];
    $buscoPorUbicacion=true;
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();
@$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.
//fechaAux establece el limite minimo de busqueda
$fechaAux = date("Y-m-d",strtotime($fecha_actual."+ 6 months"));
$max = date("Y-m-d",strtotime($fecha_actual."+ 12 months"));

$idUser = $_SESSION['id'];
$resultadoActualizar = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = $idUser");
$registroActualizar = mysqli_fetch_assoc($resultadoActualizar);
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
                        <li>
                        <?php if(($registroActualizar['suscripto'] == 'no') and ($registroActualizar['actualizar'] == 'no')){
                            echo "<button id='btn-suscribirse' class='btn btn-primary'><a style='color: white;' href='infoSuscribirse.php'>".'Suscribirse'."</a></button>";
                            }
                         ?>
                        </li>
                      <li class="has-children">
                        <a style="color:black;">Buscar Residencias</a>
                        <ul class="dropdown arrow-top">
                          <li><a href="buscarDescripcion.php">Buscar por descripción</a></li>
                          <li><a href="buscarHotsale.php">Buscar por hotsale</a></li>
                          <li><a href="buscarSemanas.php">Buscar por semanas</a></li>
                          <li><a href="buscarUbicacion.php">Buscar por ubicacion</a></li>
                        </ul>
                      </li>
                      <li><a style="color:black;" href="hotsales.php">Hotsale</a></li>
                      <li>
                        <div >
                          <a href="" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <b style="color:black;"> Mi HSH </b>
                          </a>
                          <div style="cursor: pointer; width: 10%;" class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a href="listaReservas.php" class="dropdown-item enlaceEditar">Reservas realizadas</a>
                            <a href="verPerfil.php" class="dropdown-item enlaceEditar">Ver mi perfil</a>
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
                        <form name="frm" action="buscadorSubasta.php" method="GET">
                            <div class="form-group">
                              <label for="disabledTextInput">Inicio del rango de busqueda</label>
                              <input type="date" id="disabledTextInput" class="form-control" name="fechaDesde" value="<?php echo $fechaDesde;?>" min="<?php echo $fechaAux;?>" max="<?php echo $max;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledTextInput">Fin del rango de busqueda</label>
                              <input type="date" id="disabledTextInput" class="form-control" name="fechaHasta" value="<?php echo $fechaHasta;?>" min="<?php echo $fechaAux;?>" max="<?php echo $max;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledSelect">Ubicación</label>
                              <input type="text" id="disabledSelect" class="form-control" name="ubicacion" value="<?php echo $ubicacion;?>" placeholder="">
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                           
                        </form>
                    </div>
                </div>
            </div>
                    <?php  
                    if (($buscoPorUbicacion)&&($arrayMatriz==NULL)) {
                       $qry="SELECT * FROM semana WHERE ((num_semana BETWEEN '$semanaFD' AND '$semanaFH') AND (anio BETWEEN '$anioFD' AND '$anioFH') AND (en_subasta='si'))";
                       

                       $resultadoQry = mysqli_query($conexion, $qry);
                       $f=0;$j=0;
                       while($registro = mysqli_fetch_assoc($resultadoQry)){
                            $idSemana=$registro['id'];
                            //por cada idSemana busco la subasta correspondiente
                            
                            $querySubasta="SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_minimo, s.puja_ganadora, s.inicia, s.id_semana, r.id AS idResi, s.id AS idSubasta FROM residencia r INNER JOIN subasta s ON r.id = s.id_residencia WHERE (id_semana=$idSemana AND r.ubicacion='$ubicacion') ORDER BY s.id_semana";
                        
                            
                            $resultadoSubasta = mysqli_query($conexion, $querySubasta);
                            $numrows=mysqli_num_rows($resultadoSubasta);
                            $arrayDimensiones[$f]=$numrows;
                            if($numrows!=0){
                                $arraySubasta=mysqli_fetch_assoc($resultadoSubasta);
                                $arrayMatriz[$f]= $arraySubasta;
                                $f++;
                            }
                        }
                        //$j tiene el limite de registros
                        //$arrayDimensiones tiene el numero de columnas de cada subasta
                        //itero desde el primera registro(arreglo)
                        $i=$empieza;

                        $p=1;//$p sirve para chequear que no muestre mas registros de los que debe
                        $longuitud=0;
                        if ($f!=0) {//si hay resultados
                            $longuitud=sizeof($arrayDimensiones);
                        }
                        if ($longuitud!=0) {
                            if ($longuitud==1) {//si solo hay un registro
                                    $m= $arrayDimensiones[$i];
                                    for ($k=0; $k < $m; $k++) { 
                                        $id = $arrayMatriz[$i]['idResi']; 
                                        $idSubasta=$arrayMatriz[$i]['idSubasta'];
                                        $nombreResi=$arrayMatriz[$i]['nombre'];
                                        $idSemana=$arrayMatriz[$i]['id_semana'];
                                        
                                        $subastaInicia = $arrayMatriz[$i]['inicia'];
                                        $fecha = date("d-m-Y",strtotime($subastaInicia));
                                        $hora = date("H:i",strtotime($subastaInicia));

                                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                                        $zonahoraria = date_default_timezone_get();
                                        @$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.

                                        //la fecha de inicio + 3 dias, que es lo que dura una subasta
                                        $fechaAux = date("Y-m-d H:i:s",strtotime($subastaInicia."+ 3 days"));

                                        //dia,mes y año del inicio de la subasta
                                        $diaInicioEjemplo = substr($subastaInicia, 8,2);
                                        $mesInicioEjemplo = substr($subastaInicia, 5, 2); 
                                        $anioInicioEjemplo = substr($subastaInicia, 0, 4); 
                                        $horaInicioEjemplo = substr($subastaInicia, 10,2);
                                        $minutosInicioEjemplo = substr($subastaInicia, 12,2);

                                        //dia en que termina la subasta
                                        $diaTerminaEjemplo = substr($fechaAux, 8,2);
                                        $mesTerminaEjemplo = substr($fechaAux, 5, 2); 
                                        $anioTerminaEjemplo = substr($fechaAux, 0, 4); 
                                        $horaTerminaEjemplo = substr($fechaAux, 10,3);
                                        $minutosTerminaEjemplo = substr($fechaAux, 14,2);

                                        //dia,mes y año actual
                                        $diaFechaAct = substr($fecha_actual, 8,2);
                                        $mesFechaAct = substr($fecha_actual, 5, 2); 
                                        $anioFechaAct = substr($fecha_actual, 0, 4);
                                        $horaFechaAct = substr($fecha_actual, 10, 2); 
                                        $minutosFechaAct = substr($fecha_actual, 12, 2); 


                                        $semanaQuery="SELECT * FROM semana WHERE id = '$idSemana'";
                                        $resultadoSemana=mysqli_query($conexion,$semanaQuery);

                                        $registroSemana=mysqli_fetch_assoc($resultadoSemana);
                                        $week=$registroSemana['num_semana'];
                                        $anio=$registroSemana['anio'];
                                        for($c=0; $c<7; $c++){
                                            if ($c == 0) {
                                                $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $c . ' day')) .$anio;
                                            }
                                            if ($c == 6) {
                                                 $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $c . ' day')) .$anio;
                                            }
                                        }

                                        $diaInicia = substr($inicia, 0,2);
                                        $mesInicia = substr($inicia, 3, 2); 
                                        $anioInicia = substr($inicia, 6, 4);

                                        $diaTermina = substr($termina, 0,2);
                                        $mesTermina = substr($termina, 3, 2);
                                        $anioTermina = substr($termina, 6, 4);

                                        //aca chequeo si empezo y no termino la subasta
                                        if ($anioFechaAct == $anioInicioEjemplo) {//tienen el mismo año
                                          //si el año es igual, hay que chequear el mes
                                          if ($mesFechaAct == $mesInicioEjemplo) {//tienen el mismo mes
                                              //chequeo que la subasta inicio y no termino
                                              if (($diaFechaAct>=$diaInicioEjemplo)&&($diaFechaAct <= $diaTerminaEjemplo)) {
                                                //si es el dia de la terminacion, entonces chequeo la hora y minutos
                                                if ($diaFechaAct == $diaTerminaEjemplo) {
                                                  //ahora chequeo la hora de inicio
                                                  if ($horaFechaAct>=$horaInicioEjemplo){//si es mayor o igual a la hora actual
                                                    if ($horaFechaAct>$horaInicioEjemplo) {//si la hora actual paso la hora en que inicia la subasta, entonces comienza la subasta
                                                          //entonces la subasta ya empezo
                                                        $j++;
                                                        echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                          <div class='card h-100'>
                                                            <a href='residencia.php?id=$id'>
                                                              <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                            </a>
                                                            <div class='card-body'>
                                                              <h4 class='card-title'>
                                                                <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                  ".$nombreResi."
                                                                </a>
                                                              </h4>
                                                              <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                              <p>Periodo de reserva<br>
                                                              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                              </br>
                                                              <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                            </div>
                                                          </div>
                                                        </div>";
                                                    //si tienen la misma hora, hay que chequear los minutos
                                                    }elseif ($horaFechaAct==$horaInicioEjemplo) {
                                                        if ($minutosFechaAct>=$minutosInicioEjemplo) {
                                                            //entonces la subasta ya empezo
                                                            $j++;
                                                            echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                              <div class='card h-100'>
                                                                <a href='residencia.php?id=$id'>
                                                                  <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                                </a>
                                                                <div class='card-body'>
                                                                  <h4 class='card-title'>
                                                                    <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                      ".$nombreResi."
                                                                    </a>
                                                                  </h4>
                                                                  <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                                  <p>Periodo de reserva</br>
                                                                  <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                                  </br>
                                                                  <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                                </div>
                                                              </div>
                                                            </div>";
                                                        }
                                                    }
                                                  }//cierra el if ($horaFechaAct<=$horaInicioEjemplo)
                                                }else{//si todavia no es el ultimo dia de la subasta
                                                  //entonces la subasta ya empezo
                                                   $j++;
                                                   echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                          <div class='card h-100'>
                                                            <a href='residencia.php?id=$id'>
                                                              <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                            </a>
                                                            <div class='card-body'>
                                                              <h4 class='card-title'>
                                                                <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                  ".$nombreResi."
                                                                </a>
                                                              </h4>
                                                              <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                              <p>Periodo de reserva</br>
                                                              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                              </br>
                                                              <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                            </div>
                                                          </div>
                                                        </div>";
                                                }
                                              }//este cierra el  if (($diaFechaAct>=$diaInicioEjemplo)&&($diaFechaAct <= $diaTerminaEjemplo))
                                              elseif ($diaFechaAct<$diaInicioEjemplo) { 
                                                  //la subasta no empezo
                                                  $j++;
                                                  echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                          <div class='card h-100'>
                                                            <a href='residencia.php?id=$id'>
                                                              <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                            </a>
                                                            <div class='card-body'>
                                                              <h4 class='card-title'>
                                                                <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                  ".$nombreResi."
                                                                </a>
                                                              </h4>
                                                              <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                          <p>Semana a subastar</br>
                                                          <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                        </div>
                                                      </div>
                                                    </div>";
                                              }
                                          }//este cierra el if($mesFechaAct == $mesInicioEjemplo)
                                          elseif ($mesFechaAct<$mesInicioEjemplo) {
                                              //la subasta no empezo
                                              $j++;
                                              echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                      <div class='card h-100'>
                                                        <a href='residencia.php?id=$id'>
                                                          <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                        </a>
                                                        <div class='card-body'>
                                                          <h4 class='card-title'>
                                                            <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                              ".$nombreResi."
                                                            </a>
                                                          </h4>
                                                          <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                      <p>Semana a subastar</br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                    </div>
                                                  </div>
                                                </div>";
                                          }
                                        }
                                        //aca chequeo si todavia no empezo la subasta
                                        elseif($anioFechaAct < $anioInicioEjemplo){//la subasta no comenzo todavia
                                              //aca hay que mostra la fecha en que inicia la subasta
                                              $j++;
                                              echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                      <div class='card h-100'>
                                                        <a href='residencia.php?id=$id'>
                                                          <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                        </a>
                                                        <div class='card-body'>
                                                          <h4 class='card-title'>
                                                            <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                              ".$nombreResi."
                                                            </a>
                                                          </h4>
                                                          <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                      <p>Semana a subastar</br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                    </div>
                                                  </div>
                                                </div>";
                                        }

                                    }//este cerraria el primer for
                                    if ($p==($por_pagina)) {
                                        $i=$j;
                                        $p=0;
                                    }
                                    $p++;
                                if ($arrayMatriz==NULL) {
                                    echo "<p style='color:red;'>No se encontraron resultados.</p>";
                                }
                            }else{//si hay mas de un resultado
                                for ($i; $i <= $f; $i++) {
                                    //itero en el arreglo individual
                                    $m= $arrayDimensiones[$i];
                                    for ($k=0; $k < $m; $k++) { 
                                        $id = $arrayMatriz[$i]['idResi']; 
                                        $idSubasta=$arrayMatriz[$i]['idSubasta'];
                                        $nombreResi=$arrayMatriz[$i]['nombre'];
                                        $idSemana=$arrayMatriz[$i]['id_semana'];
                                        
                                        $subastaInicia = $arrayMatriz[$i]['inicia'];
                                        $fecha = date("d-m-Y",strtotime($subastaInicia));
                                        $hora = date("H:i",strtotime($subastaInicia));

                                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                                        $zonahoraria = date_default_timezone_get();
                                        @$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.

                                        //la fecha de inicio + 3 dias, que es lo que dura una subasta
                                        $fechaAux = date("Y-m-d H:i:s",strtotime($subastaInicia."+ 3 days"));

                                        //dia,mes y año del inicio de la subasta
                                        $diaInicioEjemplo = substr($subastaInicia, 8,2);
                                        $mesInicioEjemplo = substr($subastaInicia, 5, 2); 
                                        $anioInicioEjemplo = substr($subastaInicia, 0, 4); 
                                        $horaInicioEjemplo = substr($subastaInicia, 10,2);
                                        $minutosInicioEjemplo = substr($subastaInicia, 12,2);

                                        //dia en que termina la subasta
                                        $diaTerminaEjemplo = substr($fechaAux, 8,2);
                                        $mesTerminaEjemplo = substr($fechaAux, 5, 2); 
                                        $anioTerminaEjemplo = substr($fechaAux, 0, 4); 
                                        $horaTerminaEjemplo = substr($fechaAux, 10,3);
                                        $minutosTerminaEjemplo = substr($fechaAux, 14,2);

                                        //dia,mes y año actual
                                        $diaFechaAct = substr($fecha_actual, 8,2);
                                        $mesFechaAct = substr($fecha_actual, 5, 2); 
                                        $anioFechaAct = substr($fecha_actual, 0, 4);
                                        $horaFechaAct = substr($fecha_actual, 10, 2); 
                                        $minutosFechaAct = substr($fecha_actual, 12, 2); 


                                        $semanaQuery="SELECT * FROM semana WHERE id = '$idSemana'";
                                        $resultadoSemana=mysqli_query($conexion,$semanaQuery);

                                        $registroSemana=mysqli_fetch_assoc($resultadoSemana);
                                        $week=$registroSemana['num_semana'];
                                        $anio=$registroSemana['anio'];
                                        for($c=0; $c<7; $c++){
                                            if ($c == 0) {
                                                $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $c . ' day')) . '<br />';
                                            }
                                            if ($c == 6) {
                                                 $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $c . ' day')) . '<br />';
                                            }
                                        }

                                        $diaInicia = substr($inicia, 0,2);
                                        $mesInicia = substr($inicia, 3, 2); 
                                        $anioInicia = substr($inicia, 6, 4);

                                        $diaTermina = substr($termina, 0,2);
                                        $mesTermina = substr($termina, 3, 2);
                                        $anioTermina = substr($termina, 6, 4);

                                        //aca chequeo si empezo y no termino la subasta
                                        if ($anioFechaAct == $anioInicioEjemplo) {//tienen el mismo año
                                          //si el año es igual, hay que chequear el mes
                                          if ($mesFechaAct == $mesInicioEjemplo) {//tienen el mismo mes
                                              //chequeo que la subasta inicio y no termino
                                              if (($diaFechaAct>=$diaInicioEjemplo)&&($diaFechaAct <= $diaTerminaEjemplo)) {
                                                //si es el dia de la terminacion, entonces chequeo la hora y minutos
                                                if ($diaFechaAct == $diaTerminaEjemplo) {
                                                  //ahora chequeo la hora de inicio
                                                  if ($horaFechaAct>=$horaInicioEjemplo){//si es mayor o igual a la hora actual
                                                    if ($horaFechaAct>$horaInicioEjemplo) {//si la hora actual paso la hora en que inicia la subasta, entonces comienza la subasta
                                                          //entonces la subasta ya empezo
                                                        $j++;
                                                        echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                          <div class='card h-100'>
                                                            <a href='residencia.php?id=$id'>
                                                              <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                            </a>
                                                            <div class='card-body'>
                                                              <h4 class='card-title'>
                                                                <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                  ".$nombreResi."
                                                                </a>
                                                              </h4>
                                                              <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                              <p>Periodo de reserva<br>
                                                              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                              </br>
                                                              <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                            </div>
                                                          </div>
                                                        </div>";
                                                    //si tienen la misma hora, hay que chequear los minutos
                                                    }elseif ($horaFechaAct==$horaInicioEjemplo) {
                                                        if ($minutosFechaAct>=$minutosInicioEjemplo) {
                                                            //entonces la subasta ya empezo
                                                            $j++;
                                                            echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                              <div class='card h-100'>
                                                                <a href='residencia.php?id=$id'>
                                                                  <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                                </a>
                                                                <div class='card-body'>
                                                                  <h4 class='card-title'>
                                                                    <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                      ".$nombreResi."
                                                                    </a>
                                                                  </h4>
                                                                  <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                                  <p>Periodo de reserva</br>
                                                                  <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                                  </br>
                                                                  <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                                </div>
                                                              </div>
                                                            </div>";
                                                        }
                                                    }
                                                  }//cierra el if ($horaFechaAct<=$horaInicioEjemplo)
                                                }else{//si todavia no es el ultimo dia de la subasta
                                                  //entonces la subasta ya empezo
                                                   $j++;
                                                   echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                          <div class='card h-100'>
                                                            <a href='residencia.php?id=$id'>
                                                              <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                            </a>
                                                            <div class='card-body'>
                                                              <h4 class='card-title'>
                                                                <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                  ".$nombreResi."
                                                                </a>
                                                              </h4>
                                                              <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                              <p>Periodo de reserva</br>
                                                              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                              </br>
                                                              <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                            </div>
                                                          </div>
                                                        </div>";
                                                }
                                              }//este cierra el  if (($diaFechaAct>=$diaInicioEjemplo)&&($diaFechaAct <= $diaTerminaEjemplo))
                                              elseif ($diaFechaAct<$diaInicioEjemplo) { 
                                                  //la subasta no empezo
                                                  $j++;
                                                  echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                          <div class='card h-100'>
                                                            <a href='residencia.php?id=$id'>
                                                              <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                            </a>
                                                            <div class='card-body'>
                                                              <h4 class='card-title'>
                                                                <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                                  ".$nombreResi."
                                                                </a>
                                                              </h4>
                                                              <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                          <p>Semana a subastar</br>
                                                          <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                        </div>
                                                      </div>
                                                    </div>";
                                              }
                                          }//este cierra el if($mesFechaAct == $mesInicioEjemplo)
                                          elseif ($mesFechaAct<$mesInicioEjemplo) {
                                              //la subasta no empezo
                                              $j++;
                                              echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                      <div class='card h-100'>
                                                        <a href='residencia.php?id=$id'>
                                                          <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                        </a>
                                                        <div class='card-body'>
                                                          <h4 class='card-title'>
                                                            <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                              ".$nombreResi."
                                                            </a>
                                                          </h4>
                                                          <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                      <p>Semana a subastar</br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                    </div>
                                                  </div>
                                                </div>";
                                          }
                                        }
                                        //aca chequeo si todavia no empezo la subasta
                                        elseif($anioFechaAct < $anioInicioEjemplo){//la subasta no comenzo todavia
                                              //aca hay que mostra la fecha en que inicia la subasta
                                              $j++;
                                              echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                      <div class='card h-100'>
                                                        <a href='residencia.php?id=$id'>
                                                          <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                        </a>
                                                        <div class='card-body'>
                                                          <h4 class='card-title'>
                                                            <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                              ".$nombreResi."
                                                            </a>
                                                          </h4>
                                                          <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                      <p>Semana a subastar</br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                    </div>
                                                  </div>
                                                </div>";
                                        }

                                    }//este cerraria el primer for
                                    if ($p==($por_pagina)) {
                                        $i=$j;
                                        $p=0;
                                    }
                                    $p++;
                                }//este cerraria el ultimo for
                            }
                        }
                        if ($arrayMatriz==NULL) {
                            echo "<p style='color:red;'>No se encontraron resultados.</p>";
                        }
                    }else{//si no busco por localidad

                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $idSemana=$fila['id'];
                            //por cada idSemana busco la subasta correspondiente
                            $querySubasta="SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_minimo, s.puja_ganadora, s.inicia, s.id_semana, r.id AS idResi, s.id AS idSubasta FROM residencia r INNER JOIN subasta s ON r.id = s.id_residencia WHERE id_semana=$idSemana";
                            $resultadoSubasta = mysqli_query($conexion, $querySubasta);
                            $numrows=mysqli_num_rows($resultadoSubasta);
                            if($numrows!=0){
                   
                                $arraySubasta=mysqli_fetch_assoc($resultadoSubasta);

                                $id = $arraySubasta['idResi']; $j++;
                                $idSubasta=$arraySubasta['idSubasta'];
                                $UbicaciónSubasta=$arraySubasta['ubicacion'];
                                $subastaInicia = $arraySubasta['inicia'];
                                $fecha = date("d-m-Y",strtotime($subastaInicia));
                                $hora = date("H:i",strtotime($subastaInicia));

                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                $zonahoraria = date_default_timezone_get();
                                @$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.

                                //la fecha de inicio + 3 dias, que es lo que dura una subasta
                                $fechaAux = date("Y-m-d H:i:s",strtotime($subastaInicia."+ 3 days"));

                                //dia,mes y año del inicio de la subasta
                                $diaInicioEjemplo = substr($subastaInicia, 8,2);
                                $mesInicioEjemplo = substr($subastaInicia, 5, 2); 
                                $anioInicioEjemplo = substr($subastaInicia, 0, 4); 
                                $horaInicioEjemplo = substr($subastaInicia, 10,2);
                                $minutosInicioEjemplo = substr($subastaInicia, 12,2);

                                //dia en que termina la subasta
                                $diaTerminaEjemplo = substr($fechaAux, 8,2);
                                $mesTerminaEjemplo = substr($fechaAux, 5, 2); 
                                $anioTerminaEjemplo = substr($fechaAux, 0, 4); 
                                $horaTerminaEjemplo = substr($fechaAux, 10,3);
                                $minutosTerminaEjemplo = substr($fechaAux, 14,2);

                                //dia,mes y año actual
                                $diaFechaAct = substr($fecha_actual, 8,2);
                                $mesFechaAct = substr($fecha_actual, 5, 2); 
                                $anioFechaAct = substr($fecha_actual, 0, 4);
                                $horaFechaAct = substr($fecha_actual, 10, 2); 
                                $minutosFechaAct = substr($fecha_actual, 12, 2); 
                                $semanaQuery="SELECT * FROM semana WHERE id = '$idSemana'";
                                $resultadoSemana=mysqli_query($conexion,$semanaQuery);

                                $registroSemana=mysqli_fetch_assoc($resultadoSemana);
                                $week=$registroSemana['num_semana'];
                                $anio=$registroSemana['anio'];
                                for($i=0; $i<7; $i++){
                                    if ($i == 0) {
                                        $inicia =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $i . ' day'.$anio));
                                    }
                                    if ($i == 6) {
                                         $termina =date('d-m-Y', strtotime('01/01 +' . ($week - 1) . ' weeks saturday +' . $i . ' day'.$anio));
                                    }
                                }

                                $diaInicia = substr($inicia, 0,2);
                                $mesInicia = substr($inicia, 3, 2); 
                                $anioInicia = substr($inicia, 6, 4);

                                $diaTermina = substr($termina, 0,2);
                                $mesTermina = substr($termina, 3, 2);
                                $anioTermina = substr($termina, 6, 4);

                                //aca chequeo si empezo y no termino la subasta
                                if ($anioFechaAct == $anioInicioEjemplo) {//tienen el mismo año

                                  //si el año es igual, hay que chequear el mes
                                  if ($mesFechaAct == $mesInicioEjemplo) {//tienen el mismo mes

                                      //chequeo que la subasta inicio y no termino
                                      if (($diaFechaAct>=$diaInicioEjemplo)&&($diaFechaAct <= $diaTerminaEjemplo)) {

                                        //si es el dia de la terminacion, entonces chequeo la hora y minutos
                                        if ($diaFechaAct == $diaTerminaEjemplo) {

                                          //ahora chequeo la hora de inicio
                                          if ($horaFechaAct>=$horaInicioEjemplo){//si es mayor o igual a la hora actual
                                            if ($horaFechaAct>$horaInicioEjemplo) {//si la hora es menor todavia se puede pujar
                                                $j++;
                                                echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                  <div class='card h-100'>
                                                    <a href='residencia.php?id=$id'>
                                                      <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                    </a>
                                                    <div class='card-body'>
                                                      <h4 class='card-title'>
                                                        <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                          ".$arraySubasta['nombre']."
                                                        </a>
                                                      </h4>
                                                      <h5>Ubicación: ".$arraySubasta['ubicacion']."</h5>
                                                      <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                      <p>Periodo de reserva<br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                      </br>
                                                      <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                    </div>
                                                  </div>
                                                </div>";
                                            //si tienen la misma hora, hay que chequear los minutos
                                            }elseif ($horaFechaAct==$horaInicioEjemplo) {
                                                if ($minutosFechaAct>=$minutosInicioEjemplo) {
                                                    //entonces la subasta ya empezo
                                                    $j++;
                                                    echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                      <div class='card h-100'>
                                                        <a href='residencia.php?id=$id'>
                                                          <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                        </a>
                                                        <div class='card-body'>
                                                          <h4 class='card-title'>
                                                            <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                              ".$arraySubasta['nombre']."
                                                            </a>
                                                          </h4>
                                                          <h5>Ubicación: ".$arraySubasta['ubicacion']."</h5>
                                                          <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                          <p>Periodo de reserva</br>
                                                          <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                          </br>
                                                          <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                        </div>
                                                      </div>
                                                    </div>";
                                                }
                                            }
                                           }
                                        }else{//si todavia no es el ultimo dia de la subasta
                                          //entonces la subasta ya empezo
                                           $j++;
                                           echo"<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                  <div class='card h-100'>
                                                    <a href='residencia.php?id=$id'>
                                                      <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                    </a>
                                                    <div class='card-body'>
                                                      <h4 class='card-title'>
                                                        <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                          ".$arraySubasta['nombre']."
                                                        </a>
                                                      </h4>
                                                      <h5>Ubicación: ".$arraySubasta['ubicacion']."</h5>
                                                      <h5>Esta subasta termina el día ".$diaTerminaEjemplo."-".$mesTerminaEjemplo."-".$anioTerminaEjemplo." a las ".$horaTerminaEjemplo.":".$minutosTerminaEjemplo."</h5>
                                                      <p>Periodo de reserva</br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p>
                                                      </br>
                                                      <a class='btn btn-info' href='subasta.php?id= $idSubasta'>Pujar</a>
                                                    </div>
                                                  </div>
                                                </div>";
                                        }
                                      //si es el mismo mes pero el dia no paso
                                      }elseif (($diaFechaAct<$diaInicioEjemplo)) {
                                            $j++;
                                              echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                                      <div class='card h-100'>
                                                        <a href='residencia.php?id=$id'>
                                                          <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                        </a>
                                                        <div class='card-body'>
                                                          <h4 class='card-title'>
                                                            <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                              ".$arraySubasta['nombre']."
                                                            </a>
                                                          </h4>
                                                          <h5>Ubicación: ".$arraySubasta['ubicacion']."</h5>
                                                          <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                                      <p>Semana a subastar</br>
                                                      <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                                    </div>
                                                  </div>
                                                </div>";
                                          
                                      }
                                  }
                                  elseif ($mesFechaAct<$mesInicioEjemplo) {//si el mes no es mismo, la subasta no comenzo
                                      $j++;
                                      echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                              <div class='card h-100'>
                                                <a href='residencia.php?id=$id'>
                                                  <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                </a>
                                                <div class='card-body'>
                                                  <h4 class='card-title'>
                                                    <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                      ".$arraySubasta['nombre']."
                                                    </a>
                                                  </h4>
                                                  <h5>Ubicación: ".$arraySubasta['ubicacion']."</h5>
                                                  <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                              <p>Semana a subastar</br>
                                              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                            </div>
                                          </div>
                                        </div>";
                                  }
                                }
                                //aca chequeo si todavia no empezo la subasta
                                elseif($anioFechaAct < $anioInicioEjemplo){//la subasta no comenzo todavia
                                      //aca hay que mostra la fecha en que inicia la subasta
                                      $j++;
                                      echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                                              <div class='card h-100'>
                                                <a href='residencia.php?id=$id'>
                                                  <img style='height:200px;' class='card-img-top' src='foto.php?id=$id' alt=''>
                                                </a>
                                                <div class='card-body'>
                                                  <h4 class='card-title'>
                                                    <a style='text-decoration: none;' href='residencia.php?id=$id'>
                                                      ".$arraySubasta['nombre']."
                                                    </a>
                                                  </h4>
                                                  <h5>Ubicación: ".$arraySubasta['ubicacion']."</h5>
                                                  <h5>La subasta comienza el ".$fecha." a las ".$hora."</h5>
                                              <p>Semana a subastar</br>
                                              <i style='font-size:11px;'>Del día ".$diaInicia."-".$mesInicia."-".$anio." al día ".$diaTermina."-".$mesTermina."-".$anio."</i></p> 
                                            </div>
                                          </div>
                                        </div>";
                                  
                                }
                            }
                            
                        }//aca termina el while
                        if ($j==0) {
                            echo "<p style='color:red;'>No se encontraron resultados.</p>";
                        }
                    }//aca termina el else
                        ?>
        </div>
    </div>
    <?php

    ?>
    <div class="clearfix">
        <?php
        if (!$buscoPorUbicacion){
            $f=0;
        }
        if (($f>4)&&($buscoPorUbicacion)){ 
            $mayor=true;
        }elseif (($num>4)&&(!$buscoPorUbicacion)) {
            $mayor=true;
        }else $mayor=false;
        ?>
        <nav style="margin-right: 50%;" aria-label="Page navigation example">
            <!-- <div class="hint-text ml-5">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros;?></b> registros</div> -->
            <ul class="pagination mr-5">
            <?php 

                if ($mayor) {//si hay suficientes registros para paginar
                    if (isset($_GET['j'])&&($buscoPorUbicacion)) {
                        $f=$_GET['j'];
                    }
                    elseif (isset($_GET['j'])) {
                        $j=$_GET['j'];
                    }
                    if ($buscoPorUbicacion) {
                        $total_paginas = ceil($f / $por_pagina);
                        for ($i = 1; $i < $total_paginas; $i++) {
                            echo "<li class='page-item'>
                            <a href='buscadorSubasta.php?pagina=" . $i . "&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta."&ubicacion=".$ubicacion."&j=".$f."' class='page-link'>" . $i . "</a>
                          </li>";
                        }
                        //ultimo boton de paginacion
                        echo "<li class='page-item'>
                            <a href='buscadorSubasta.php?pagina=" . $total_paginas . "&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta."&ubicacion=".$ubicacion."&j=".$f."' class='page-link'>Ultimos resultados</a>
                          </li>";
                    }
                    else{ $total_paginas = ceil($num / $por_pagina);
                        for ($i = 1; $i < $total_paginas; $i++) {
                            echo "<li class='page-item'>
                            <a href='buscadorSubasta.php?pagina=" . $i . "&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta."&ubicacion=".$ubicacion."&j=".$j."' class='page-link'>" . $i . "</a>
                          </li>";
                        }
                        //ultimo boton de paginacion
                        echo "<li class='page-item'>
                            <a href='buscadorSubasta.php?pagina=" . $total_paginas . "&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta."&ubicacion=".$ubicacion."&j=".$j."' class='page-link'>Ultimos resultados</a>
                          </li>";
                    }
                }
            ?>

            </ul>
        </nav>
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