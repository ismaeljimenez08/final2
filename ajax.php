<?php
session_start();
include "recursos/c_d.php";
if($_GET['get_lat_lng']){
	$query = "SELECT id_anuncio,titulo,latitud,longitud FROM `anuncio` WHERE `estado`='1'";
	$rs = mysqli_query($link, $query) or die ('Error de al consultar la base de datos: ' . mysqli_error($link));
	$datos;
	$x = 0;
	while($fila = mysqli_fetch_assoc($rs)){
		$datos['id'][$x] = $fila['id_anuncio'];
		$datos['titulo'][$x] = $fila['titulo'];
		$datos['lat'][$x] = $fila['latitud'];
		$datos['lng'][$x] = $fila['longitud'];
		$x++;
	};
	mysqli_free_result($rs);
	mysqli_close($link);
	echo json_encode($datos);
	exit();
} else if(isset($_POST['filtro'])){
$query = "";
$query1 = "SELECT id_usuario,correo,cedula FROM `usuario` WHERE `usuario`.";
if($_POST['filtro'] == "1"){
$query = "DELETE FROM `usuario` WHERE `usuario`.`correo`='{$_POST['correo']}'";
$query1=$query1."`correo`='{$_POST['correo']}'";
} else {
$query = "DELETE FROM `usuario` WHERE `usuario`.`cedula`='{$_POST['cedula']}'";
$query1=$query1."`cedula`='{$_POST['cedula']}'";
}
$res=mysqli_query($link, $query1);
echo $query1;
$datos;
$x=0;
while($row=mysqli_fetch_assoc($res)){
	$datos[$x] = $row['id_usuario'];
	$x++;
}
mysqli_free_result($res);
foreach($datos as $d){
	$query3 = "DELETE FROM `anuncio` WHERE `anuncio`.`fk_creador`='{$d}'";
	mysqli_query($link, $query3) or ("Error al eliminar anuncios: ".mysqli_error($link));
}
mysqli_query($link, $query) or die ("No se pudo eliminar el campo: ".mysqli_error($link));
mysqli_close($link);
header("Location:s_admin/");
} else if($_POST['enviado'] != ""){
	if($_POST['enviado'] == "a"){
		$query = "INSERT INTO `{$db}`.`tipo_inmueble` (nombre) values ('{$_POST['tipo']}')";
	} else if($_POST['enviado'] == "e"){
		$query = "UPDATE `{$db}`.`tipo_inmueble` SET `nombre`='{$_POST['tipo']}' WHERE `id_tipo`='{$_POST['tipo2']}'";
	}
mysqli_query($link, $query);
mysqli_close($link);
header("Location:s_admin/");
} else if($_POST['enviado1'] != ""){
	if($_POST['enviado1'] == "a"){
		$query = "INSERT INTO `{$db}`.`accion_dato` (nombre_accion) values ('{$_POST['accion']}')";
	} else if($_POST['enviado1'] == "e"){
		$query = "UPDATE `{$db}`.`accion_dato` SET `nombre_accion`='{$_POST['accion']}' WHERE `id_accion`='{$_POST['accion2']}'";
	}
mysqli_query($link, $query);
mysqli_close($link);
header("Location:s_admin/");
}
header("Location:s_admin/");
?>