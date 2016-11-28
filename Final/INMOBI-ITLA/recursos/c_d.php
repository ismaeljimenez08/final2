<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "final_web";
$link = mysqli_connect($server, $user, $pass, $db);
function errores($val){
	if(!$val){
		$message = 'Error de al consultar la base de datos: ' . mysql_error();
		die($message);
	}
}
