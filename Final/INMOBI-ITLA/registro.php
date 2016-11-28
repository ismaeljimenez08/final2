<?php
session_start();
if(!$_POST['correo']){
$_SESSION['mensaje'] = "Debe completar los campos";
header("Location:./");
exit();
} else if($_POST['clave1'] != $_POST['clave2']){
$_SESSION['mensaje'] = "Las claves no coinciden";
header("Location:./");
exit();
}
require "recursos/c_d.php";
$tipo = "1";
if($_SESSION['tipo'] == "2"){
	if($_POST['tipo'] == "2"){
		$tipo = "2";
	} else {
		$tipo = "1";
	}
} else {
	$tipo = "1";
}
$query = "INSERT INTO `{$db}`.`usuario` (cedula,tipo,clave,correo,nombre,apellido,telefono,celular,fax,mas_info) values ('{$_POST['cedula']}','{$tipo}','{$_POST['clave1']}','{$_POST['correo']}','{$_POST['nombre']}','{$_POST['apellido']}','{$_POST['telefono']}','{$_POST['celular']}','{$_POST['fax']}','{$_POST['mas_info']}')";
mysqli_query($link, $query) or die("Error al insertar los datos ".mysqli_error($link));
mysqli_close($link);
header("Location:./s_admin/");