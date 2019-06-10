<?php
    Include("DB.php");
	$conexion = conectar();				

	$nombre = $_POST['nombre'];
	$capacidad = $_POST['capacidad'];
	$ubicacion = $_POST['ubicacion'];
	$direccion = $_POST['direccion'];
	$descripcion = $_POST['descripcion'];

	if (($nombre != null) AND ($capacidad != null) AND ($ubicacion != null) AND ($direccion != null) AND ($descripcion != null)) {

		if(!empty($_FILES['foto']['name'])) {//verifica que la foto este definida
			$archivo = $_FILES['foto']['tmp_name'];
			$tamanio = $_FILES['foto']['size'];
			$fp = fopen($archivo, "r");//abre el fichero. Con "r" es para solo lectura
			$contenido = fread($fp, $tamanio);//fread: Lectura de un fichero en modo binario seguro, lee el archivo abierto con fopen hasta $tamanio
			$contenido = addslashes($contenido);//Devuelve un string con barras invertidas delante de los caracteres que necesitan ser escapados. 
			fclose($fp);//Cierra un puntero a un archivo abierto

			//valido que no haya un nombre repetido en la BD 
			$query = "SELECT * FROM residencia WHERE nombre = '$nombre'";
			$resultado = mysqli_query($conexion, $query);
			$rows = mysqli_num_rows($resultado);
			if ($rows == 0) {

				if( mysqli_query($conexion,"INSERT INTO residencia 
											SET nombre = '$nombre', activo = 'si', foto = '$contenido', capacidad = $capacidad, ubicacion = '$ubicacion', direccion = '$direccion', en_subasta = 'no', en_hotsale = 'no', descrip = '$descripcion'")){
						$id = mysqli_insert_id($conexion);
						for ($i = 1; $i <= 52; $i++) { #genero las 52 semanas anuales
							$semana = date("w")+$i; #empieza desde la semana que le sigue a la que se le da de alta
							$j= $i * 7;
							$date= strtotime("+ $j day");
							$fecha = date('y-m-d',$date);
							if(mysqli_query($conexion, "INSERT INTO semana SET id_residencia = $id , periodo = $semana , fecha = '$fecha'")){
								echo($fecha);
								echo("semana agregada");
							}
							
						}
						echo '<script> alert("La operación se completo correctamente");
						window.location = "crudResidencia.php";</script>';
				}else{ echo '<script> alert("No se pudo agregar el registo al sistema.");
								window.location = "crudResidencia.php";</script>';
					} 
				
			}else { echo '<script>alert("ERROR!. La residencia ya existe y no puede volver a insertarte.");
					window.location = "crudResidencia.php";</script>';
				}

		}else{ echo '<script>alert("ERROR!. El campo de la portada es obligatorio.");
					</script>';
			}	

	}
	else {echo '<script>alert("Todos los campos son obligatorios. Complete todos los campos e intentelo nuevamente.");
			window.location = "crudResidencia.php";</script>';
		}	
	
?>