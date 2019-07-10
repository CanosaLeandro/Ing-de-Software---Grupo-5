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
        $por_pagina = 5;
    
        //si se presiono algun indice de la paginacion
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }else{
            $pagina = 1;
        }
    
        //la pagina inicia en 0 y se multiplica por $por_pagina
    
        $empieza = ($pagina - 1) * $por_pagina;
    
        $query = "SELECT r.nombre, r.ubicacion, r.capacidad, r.descrip, r.foto, s.monto_minimo, s.puja_ganadora, s.inicia, s.id_semana, r.id AS idResi, s.id AS idSubasta 
                FROM residencia r
                INNER JOIN subasta s ON r.id = s.id_residencia 
                WHERE activo='si'
                ORDER BY ubicacion LIMIT $empieza, $por_pagina";
        $resultado = mysqli_query($conexion, $query);    

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


    <div style="margin-top: 100px;" class="container">
        <div style="margin-top: 100px;" class="table-wrapper">
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
                              <label for="InputFechaFin">Fin del rango de busqueda</label>
                              <input type="date" id="InputFechaFin" class="form-control" name="fechaHasta" value="<?php echo $fechaHasta;?>" min="<?php echo $fechaAux;?>" max="" placeholder="" required>
                            </div>
                            <div class="form-group">
                              <label for="disabledSelect">Localidad</label>
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
                        <th>Nombre de la propiedad</th>
                        <th>Portada</th>
                        <th>Inicio de la subasta</th>
                        <th>Localidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php  
                        $j=0;
                        while($fila = mysqli_fetch_assoc($resultado)){
                            $id = $fila['idResi'];$j++;
                            
                            $fechaInicio = $fila['inicia'];
                            $fecha = date("d-m-Y",strtotime($fechaInicio));
                            $hora = date("H:i",strtotime($fechaInicio));
                    ?>
                            <tr>
                                <td><?php echo $fila['idSubasta'];?></td>
                                <td><?php echo utf8_encode(utf8_decode($fila['nombre']));?></td>
                                <td><img class="foto" src="foto.php?id=<?php echo $id;?>"/></td>
                                <td><?php echo  "El ".$fecha." a las ".$hora;?></td>
                                <td><?php echo utf8_encode(utf8_decode($fila['ubicacion']));?></td>
                                <td>
                                    <a href='subasta.php?id=<?php echo $id;?>'><button type="button" class="btn btn-info"><span>Ver Subasta</span></button></a>
                                </td>
                            </tr> 
                    <?php };
                        ?>
                </tbody>
            </table>
            <?php
                $qry="SELECT * FROM residencia 
                INNER JOIN subasta ON residencia.id = subasta.id_residencia ORDER BY ubicacion";
    
                $result = mysqli_query($conexion, $qry);
                //contar el total de registros
                $total_registros = mysqli_num_rows($result);
            ?>
            <div class="clearfix">
                <?php
                if(isset($total_registros)) {

                    if($total_registros>5) {

                        //usando ceil para dividir el total de registros entre $por_pagina
                        //ceil redondea un numero para abajo
                        $total_paginas = ceil($total_registros / $por_pagina);

                        ?>
                        <div class="hint-text">Mostrando <b><?php echo $j ?></b> de <b><?php echo $total_registros;?></b> registros</div>
                        <ul class="pagination">
                            
                        <?php
                            for($i=1; $i < $total_paginas; $i++){ 
                                    echo "<li class='page-item'><a href='buscar.php?pagina=$i' class='page-link'>".$i."</a></li>";
                            }
                            //link a la ultima pagina
                            echo "<li class='page-item'><a href='buscar.php?pagina=$total_paginas' class='page-link'>".'Ultimos registros'."</a></li>";
                    }
                }
                ?>
                
                </ul>
            </div>
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