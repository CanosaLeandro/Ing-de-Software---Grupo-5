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
    <title>Busqueda por semanas</title>
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
$por_pagina = 5;

//si se presiono algun indice de la paginacion
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
    if ($_GET['busco']) {
        $busco=true;
    }else $busco=false;
        
    $fechaDesde= $_GET['fechaDesde'];
    $fechaHasta= $_GET['fechaHasta'];

    if ($busco) {
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
    }
}else{
    $pagina = 1;
    $busco=false;
    $fechaDesde='';
    $fechaHasta='';
}

$empieza = ($pagina - 1) * $por_pagina;

//Esta parte es el buscador
if(isset($_GET['buscar'])){
    $busco=true;
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

    //aca chequeo que la fecha de inicio no sea mayor a la fecha de fin
    if ($anioFD==$anioFH) {
        if ($mesFD==$mesFH) {
            if ($diaFD>$diaFH) {
                echo "<script>alert('Error al buscar, la fecha de inicio no puede ser mayor a la de fin.');
                window.location='buscarSemanas.php';</script>";
            }
        }elseif ($mesFD>$mesFH) {
            echo "<script>alert('Error al buscar, la fecha de inicio no puede ser mayor a la de fin.');
                window.location='buscarSemanas.php';</script>";
        }
    }elseif ($anioFD>$anioFH) {
        echo "<script>alert('Error al buscar, la fecha de inicio no puede ser mayor a la de fin.');
                window.location='buscarSemanas.php';</script>";
    }

    //chequeo que no se supere el rango de busqueda
    if ($anioFD==$anioFH) {//si es el mismo año
        //9 semanas casi igual a 2 meses
        if (($mesFH-$mesFD)>2) {//rango de 2 meses superado
            echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
                window.location='buscarSemanas.php';</script>";
        }elseif (($mesFH-$mesFD)==2) {
            if ($diaFH>$diaFD) {    
                echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
                window.location='buscarSemanas.php';</script>";
            }
        }
    }else{//si el año es distinto
        $mesFin=($mesFH+12);
        if (($mesFin-$mesFD)>2) {
            echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
                    window.location='buscarSemanas.php';</script>";
        }elseif (($mesFin-$mesFD)==2) {
            if ($diaFH>$diaFD) {    
                echo "<script>alert('Error al buscar, el rango máximo para la búsqueda es de 2 meses.');
                window.location='buscarSemanas.php';</script>";
            }
        }
    }

}//fin del buscar

date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();
@$fecha_actual=date("Y-m-d H:i:s",time());//Establesco la fecha y hora de Bs.As.
//fechaAux establece el limite minimo de busqueda
$fechaAux = date("Y-m-d",strtotime($fecha_actual."+ 6 months"));

$max = date("Y-m-d",strtotime($fecha_actual."+ 12 months"));
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
                          <li><a href="buscarDescripcion.php">Buscar por descripción</a></li>
                          <li><a href="buscarHotsale.php">Buscar por hotsale</a></li>
                          <li><a href="buscar.php">Buscar por subasta</a></li>
                          <li><a href="buscarUbicacion.php">Buscar por ubicacion</a></li>
                        </ul>
                      </li>
                      <li><a style="color:black;" href="hotsales.php">Hotsale</a></li>
                       <li><a style="color:black;" href="subastas.php">Subastas</a></li>
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
                        <h2>Buscar por<b> Semanas libres</b></h2>
                    </div>

                    <!-- buscador por rangos de fechas -->
                    <div class="col-sm-4">
                        <form name="frm" action="buscarSemanas.php" method="GET">
                            <div class="form-group">
                              <label for="disabledTextInput">Inicio del rango de busqueda</label>
                              <input type="date" id="disabledTextInput" class="form-control" name="fechaDesde" value="<?php echo $fechaDesde;?>" min="<?php echo $fechaAux;?>" max="<?php echo $max;?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledTextInput">Fin del rango de busqueda</label>
                              <input type="date" id="disabledTextInput" class="form-control" name="fechaHasta" value="<?php echo $fechaHasta;?>" min="<?php echo $fechaAux;?>" max="<?php echo $max;?>" placeholder="" required>
                            </div>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                           
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Portada</th>
                        <th>Capacidad</th>
                        <th>Ubicación</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php  
                if ($busco) {
                    if ($anioFD<$anioFH) {//termina en el otro año 
                        //si el la busqueda no termina en el mismo año
                        $querySemana = "SELECT DISTINCT id_residencia FROM semana s
                                    INNER JOIN residencia r ON s.id_residencia=r.id 
                                    WHERE ((s.disponible = 'si') 
                                    AND (r.activo='si') 
                                    AND ((s.anio = $anioFD) 
                                    AND (s.num_semana BETWEEN $semanaFD AND 52)
                                    OR ((s.anio= $anioFH) 
                                    AND (num_semana BETWEEN 1 AND $semanaFH)))) 
                                    LIMIT $empieza, $por_pagina"; 
         
                        $sqlSemana = mysqli_query($conexion,$querySemana); 
                          
                        $j=0;
                        while ($registroSemana = mysqli_fetch_assoc($sqlSemana)){
                            $idResidencia = $registroSemana['id_residencia'];
                            $queryResidencia = "SELECT * FROM residencia WHERE id = $idResidencia ORDER BY nombre DESC"; 

                            $sqlResidencia = mysqli_query($conexion,$queryResidencia);
                            $resultResidencia = mysqli_fetch_assoc($sqlResidencia);
                            $id = $resultResidencia['id'];
                            $j++;
                            echo "
                            <tr>
                                <td>".$resultResidencia['nombre']."</td>
                                <td><img class='foto' src='foto.php?id= $id'/></td>
                                <td>".$resultResidencia['capacidad']."</td>
                                <td> ".utf8_encode(utf8_decode($resultResidencia['ubicacion']))."</td>
                                <td> ".utf8_encode(utf8_decode($resultResidencia['descrip']))."</td><td>
                                    <a href='residencia.php?id=$idResidencia'><button type='button' class='btn btn-info'><span>Ver residencia</span></button></a>
                                </td>
                            </tr>";
                        }
                        if ($j==0) {
                            echo "<tr><td style='color:red;' colspan='6'>No se encontraron resultados.</td></tr>";
                        }
                    }elseif ($anioFD==$anioFH) {//es el mismo año
                        $querySemana = "SELECT DISTINCT id_residencia FROM semana s
                                    INNER JOIN residencia r ON s.id_residencia=r.id 
                                    WHERE ((s.disponible = 'si') AND (r.activo='si') AND (s.anio = $anioFD) AND (s.num_semana 
                                    BETWEEN $semanaFD AND $semanaFH)) 
                                    LIMIT $empieza, $por_pagina"; 
                        $sqlSemana = mysqli_query($conexion,$querySemana); 
                          
                        $j=0;
                        while ($registroSemana = mysqli_fetch_assoc($sqlSemana)){
                            $idResidencia = $registroSemana['id_residencia'];
                            $queryResidencia = "SELECT * FROM residencia WHERE id = $idResidencia ORDER BY nombre DESC"; 

                            $sqlResidencia = mysqli_query($conexion,$queryResidencia);
                            $resultResidencia = mysqli_fetch_assoc($sqlResidencia);
                            $id = $resultResidencia['id'];
                            $j++;
                            echo "
                            <tr>
                                <td>".$resultResidencia['nombre']."</td>
                                <td><img class='foto' src='foto.php?id= $id'/></td>
                                <td>".$resultResidencia['capacidad']."</td>
                                <td> ".utf8_encode(utf8_decode($resultResidencia['ubicacion']))."</td>
                                <td> ".utf8_encode(utf8_decode($resultResidencia['descrip']))."</td><td>
                                    <a href='residencia.php?id=$idResidencia'><button type='button' class='btn btn-info'><span>Ver residencia</span></button></a>
                                </td>
                            </tr>";
                        }
                        if ($j==0) {
                            echo "<tr><td style='color:red;' colspan='6'>No se encontraron resultados.</td></tr>";
                        }
                    }
                }elseif(!$busco) {//si no busco pero toco paginacion
                     $querySemana="SELECT DISTINCT id_residencia FROM semana s
                                    INNER JOIN residencia r ON s.id_residencia=r.id 
                                    WHERE ((s.disponible='si') AND (r.activo='si')) 
                                    LIMIT $empieza, $por_pagina";
                     $sqlSemana = mysqli_query($conexion,$querySemana); 
                          
                        $j=0;
                        while ($registroSemana = mysqli_fetch_assoc($sqlSemana)){
                            $idResidencia = $registroSemana['id_residencia'];
                            $queryResidencia = "SELECT * FROM residencia WHERE id = $idResidencia ORDER BY nombre DESC"; 

                            $sqlResidencia = mysqli_query($conexion,$queryResidencia);
                            $resultResidencia = mysqli_fetch_assoc($sqlResidencia);
                            $id = $resultResidencia['id'];
                            $j++;
                            echo "
                            <tr>
                                <td>".$resultResidencia['nombre']."</td>
                                <td><img class='foto' src='foto.php?id= $id'/></td>
                                <td>".$resultResidencia['capacidad']."</td>
                                <td> ".utf8_encode(utf8_decode($resultResidencia['ubicacion']))."</td>
                                <td> ".utf8_encode(utf8_decode($resultResidencia['descrip']))."</td><td>
                                    <a href='residencia.php?id=$idResidencia'><button type='button' class='btn btn-info'><span>Ver residencia</span></button></a>
                                </td>
                            </tr>";
                        }
                        if ($j==0) {
                            echo "<tr><td style='color:red;' colspan='6'>No se encontraron resultados.</td></tr>";
                        }
                } 
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    if (isset($_GET['buscar'])) {
        if ($anioFD>$anioFH) {
            $query="SELECT DISTINCT id_residencia FROM semana s
                    INNER JOIN residencia r ON s.id_residencia=r.id
                    WHERE ((disponible = 'si') AND (r.activo='si') AND ((anio = $anioFD) AND num_semana
                    BETWEEN $semanaFD AND 52)
                    OR ((anio= $anioFH) AND (num_semana BETWEEN 1 AND $semanaFH)))";
        }else{
            $query="SELECT DISTINCT id_residencia FROM semana s
                    INNER JOIN residencia r ON s.id_residencia=r.id
                    WHERE ((disponible = 'si') AND (r.activo='si') AND (anio = $anioFD) AND (num_semana 
                    BETWEEN $semanaFD AND $semanaFH))";
        }
    }else{
        $query="SELECT DISTINCT id_residencia 
                FROM semana s
                INNER JOIN residencia r ON s.id_residencia=r.id 
                WHERE s.disponible='si' AND r.activo='si'";
    }
    
    $result = mysqli_query($conexion, $query);
    //contar el total de registros
    $total_registros = mysqli_num_rows($result);
    ?>
    <div class="clearfix">
        <?php
        if (isset($total_registros)) {
            if ($total_registros > 5) {
                //usando ceil para dividir el total de registros entre $por_pagina
                //ceil redondea un numero para abajo
                $total_paginas = ceil($total_registros / $por_pagina);
                $mayor=true;//si se muestra la paginacion
            }else $mayor=false;
        }
        ?>
        <nav style="margin-right: 50%;" aria-label="Page navigation example">
            <!-- <div class="hint-text ml-5">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros;?></b> registros</div> -->
            <ul class="pagination mr-5">
            <?php 
                if ($mayor) {
                    for ($i = 1; $i < $total_paginas; $i++) {
                        echo "<li class='page-item'>
                        <a href='buscarSemanas.php?pagina=" . $i . "&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta."&busco=".$busco."' class='page-link'>" . $i . "</a>
                      </li>";
                    }
                    echo "<li class='page-item'>
                        <a href='buscarSemanas.php?pagina=" . $total_paginas . "&fechaDesde=".$fechaDesde."&fechaHasta=".$fechaHasta."&busco=".$busco."' class='page-link'>Ultimos resultados</a>
                      </li>";
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