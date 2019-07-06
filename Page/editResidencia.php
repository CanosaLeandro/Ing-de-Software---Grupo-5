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

	$id = $_POST['id'];
	$nombreAnt = $_POST['nombreAnt'];
	$nombre = $_POST['nombre'];
	$capacidadAnt = $_POST['capacidadAnt'];
	$capacidad = $_POST['capacidad'];
	$ubicacionAnt = $_POST['ubicacionAnt'];
	$ubicacion = $_POST['ubicacion'];
	$descripcionAnt = $_POST['descripcionAnt'];
	$descripcion = $_POST['descripcion'];


	if ($nombreAnt != $nombre) {//si cambio el nombre


		if(!empty($_FILES['foto']['name'])) {//CAMBIO LA FOTO
			$archivo = $_FILES['foto']['tmp_name'];
			$tamanio = $_FILES['foto']['size'];
			$fp = fopen($archivo, "r");//abre el fichero. Con "r" es para solo lectura
			$contenido = fread($fp, $tamanio);//fread: Lectura de un fichero en modo binario seguro, lee el archivo abierto con fopen hasta $tamanio
			$contenido = addslashes($contenido);//Devuelve un string con barras invertidas delante de los caracteres que necesitan ser escapados. 
			fclose($fp);//Cierra un puntero a un archivo abierto
		


			$query = "SELECT COUNT(*) AS total FROM residencia WHERE nombre = '$nombre'";
			$cant = mysqli_query($conexion,$query);
			$re = mysqli_fetch_assoc($cant);
			if ($re['total'] == 0) {//no esta repetido el nombre
				
				if (mysqli_query($conexion,"UPDATE residencia 
											SET nombre = '$nombre', foto = '$contenido', capacidad = $capacidad, ubicacion = '$ubicacion', descrip = '$descripcion' 
											WHERE id = $id")){ 
					echo '<script> alert("Los datos fueron modificados exitosamente.");
							window.location = "crudResidencia.php";</script>
					';
				}else{ echo '<script> alert("No se pudieron modificar los datos.");
							window.location = "editModalResidencia.php?id='.$id.'";</script>';
				} 
				
			}else{echo '<script>alert("Error!. Ese nombre de residencia ya existe, intente con otro.");
		    		window.location = "editModalResidencia.php?id='.$id.'";</script>';}
		}else{
			$query = "SELECT COUNT(*) AS total FROM residencia WHERE nombre = '$nombre'";
			$cant = mysqli_query($conexion,$query);
			$re = mysqli_fetch_assoc($cant);
			if ($re['total'] == 0) {//no esta repetido el nombre
				
				if (mysqli_query($conexion,"UPDATE residencia 
											SET nombre = '$nombre', capacidad = $capacidad, ubicacion = '$ubicacion', descrip = '$descripcion' 
											WHERE id = $id")){ 
					echo '<script> alert("Los datos fueron modificados exitosamente.");
							window.location = "crudResidencia.php";</script>
					';
				}else{ echo '<script> alert("No se pudieron modificar los datos.");
							window.location = "editModalResidencia.php?id='.$id.'";</script>';
				} 
				
			}else{echo '<script>alert("Error!. Ese nombre de residencia ya existe, intente con otro.");
		    		window.location = "editModalResidencia.php?id='.$id.'";</script>';}
		}

	}elseif ($nombre == $nombreAnt) {

		if(!empty($_FILES['foto']['name'])) {//cambio la foto
		
			$archivo = $_FILES['foto']['tmp_name'];
			$tamanio = $_FILES['foto']['size'];
			$fp = fopen($archivo, "r");//abre el fichero. Con "r" es para solo lectura
			$contenido = fread($fp, $tamanio);//fread: Lectura de un fichero en modo binario seguro, lee el archivo abierto con fopen hasta $tamanio
			$contenido = addslashes($contenido);//Devuelve un string con barras invertidas delante de los caracteres que necesitan ser escapados. 
			fclose($fp);//Cierra un puntero a un archivo abierto
			
			if (mysqli_query($conexion,"UPDATE residencia 
										SET nombre = '$nombre', foto = '$contenido', capacidad = $capacidad, ubicacion = '$ubicacion', descrip = '$descripcion' 
										WHERE id = $id")) { echo '<script> alert("Los datos fueron modificados exitosamente.");
				window.location = "crudResidencia.php";</script>';
			}else{ echo '<script> alert("No se pudieron modificar los datos.");
						window.location = "editModalResidencia.php?id='.$id.'";</script>';
			}
		}
		else{//no cambio la foto

			if (mysqli_query($conexion,"UPDATE residencia 
										SET nombre = '$nombre', capacidad = $capacidad, ubicacion = '$ubicacion', descrip = '$descripcion' 
										WHERE id = $id")) { echo '<script> alert("Los datos fueron modificados exitosamente.");
				window.location = "crudResidencia.php";</script>';
			}else{ echo '<script> alert("No se pudieron modificar los datos.");
						window.location = "editModalResidencia.php?id='.$id.'";
						</script>';
			}
		} 
	}	
?>
