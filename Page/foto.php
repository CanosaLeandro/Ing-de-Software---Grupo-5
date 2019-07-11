<?php
// se recibe el valor que identifica la imagen en la tabla
Include("DB.php");
/*session_start();*/
$link = conectar();

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql = "SELECT foto FROM residencia WHERE id=$id";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	echo $row['foto'];
}
// se recupera la información de la imagen

mysqli_close($link);
// se imprime la imagen y se le avisa al navegador que lo que se está
// enviando no es texto, sino que es una imagen un tipo en particular

?>