<?php
session_start();
if($_SESSION['activo']){
$_SESSION['mensaje'] = "Ya existe una sesion activa";
header("Location:./");
exit();
} else if(!$_POST['correo']){
$_SESSION['mensaje'] = "no se ha especificado el correo";
header("Location:./");
exit();
}
require "recursos/c_d.php";
$usuario = $_POST['correo'];
$clave = $_POST['clave'];
$query = "SELECT * FROM `{$db}`.`usuario`";
$res = mysqli_query($link, $query);
errores($res);
while($fila= mysqli_fetch_assoc($res)){
	if($fila['correo'] == $usuario and $fila['clave'] == $clave){
		$_SESSION = $fila;
		$_SESSION['activo'] = true;
		mysqli_free_result($res);
		mysqli_close($link);
		header("Location:user.php");
		exit();
	}
}
mysqli_free_result($res);
mysqli_close($link);
$_SESSION['mensaje'] = "Correo y/o Claves incorrecto(s)";
header("Location:./");