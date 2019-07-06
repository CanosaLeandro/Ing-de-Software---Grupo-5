<!DOCTYPE html>
<html lang="es">
<?php
include("DB.php");
include("links.php");
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
?>

<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Administración de residencias</title>
      <link rel='shortcut icon' type='image/x-icon' href='Logos/Logos/favicon.png' />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style_crudResidencia.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="crudResidencia.php">
          <img style="margin-top: -8px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="mb-3 d-inline-block align-top" alt="">
          Home Switch Home
        </a>
        <a class="navbar-brand" href="crudUsuarios.php">Usuarios</a>
        <div style="margin-left: 450px;" class="d-flex align-items-end">
        <div class="ml-5 p-2">
          <a href="logoutAdmin.php" type="button" class="btn btn-danger">Cerrar sesión</a> 
        </div>
      </div>  
      </nav>

      <div class="container">
            <div class="table-wrapper">
                  
                  <div class="table-title">
                        <nav class="navbar navbar-light bg-light">
                              <a class="navbar-brand" href="home.php">
                                    <img style="margin-top: -10px;" src="Logos/Logos/HSH-Logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                               Home Switch Home
                              </a>
                        </nav>
                        <div class="row">
                              <div class="col-sm-6">
                                    <h2>Administración de <b>Residencias</b></h2>
                              </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col">
                              <?php 
                                    @$anioActual=date("Y");//Establesco el año
                              ?>
                              <form action="generarSemanas.php" method="POST">
                                <h4>Formulario de habilitación de reservas</h4>
                                <p>Este formulario es para la habilitación de reservas de las semanas disponibles de cada residencia. Una vez habilitadas las reservas de las semanas de un determinado año, se podra hacer uso de las funcionalidades del sistema para dicho año.</p>
                                <div class="form-group">
                                  <label for="exampleFormControlSelect1">Elija un año</label>
                                  <select class="form-control" id="exampleFormControlSelect1" name="anio">
                                    <?php for ($i=1; $i < 5; $i++) { 
                                          echo"<option>".$anioActual."</option>";
                                          $anioActual = date("Y",strtotime($anioActual."+ ".$i." year"));
                                    } ?>
                                  </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Habilitar semanas</button>
                              </form>
                        </div>
                  </div>     
            </div>
      </div>
</body>
</html>

