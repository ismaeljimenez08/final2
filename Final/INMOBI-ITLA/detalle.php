<?php
session_start();
require "recursos/layout.php";
$p = new plantilla();
require "recursos/c_d.php";
if($_GET['busqueda']){
	$filtro = "";
	if($_GET['filtro']){
		$filtro = "`anuncio`.`fk_tipo`='{$_GET['filtro']}' AND ";
	}
	$buscar=$_GET['buscar'];
	$query = "SELECT * FROM `{$db}`.`anuncio` WHERE {$filtro}`anuncio`.`titulo` LIKE '%{$buscar}%'";
	$rs = mysqli_query($link, $query) or die ("No se pudo realizar la busqueda: ".mysqli_error($link));
echo "<h3>Resultados de la busqueda</h3><div class='row' >";
$contador = $count =1;
$primero = false;
echo "<div name='res' id='1' >";
while($fila = mysqli_fetch_assoc($rs)){
if($count == 10){
$count = 1;
}
if($primero AND $count ==1){
	$contador++;
	echo "</div><div id='{$contador}' name='res' >";
}
	$primero = true;
	echo "<div class=' col col-xs-4'>
	<img src='anuncio/{$fila['id_anuncio']}/1' width='100%' height='200px' /><br/>Titulo: {$fila['titulo']} <br/>Precio: {$fila['precio']} para {$fila['nombre_accion']}<br/>Dia: {$fila['fecha']}<br/><a href='detalle.php?ver_mas={$fila['id_anuncio']}' >Ver mas</a></div>";
	$count++;
}
echo "</div></div><br/>
	<div class='row'><div class='col-xs-1'><button type='button' class='btn divb btn-block' onclick='ant();' >&lt;&lt;</button></div>
	<div class='col-xs-2'><input id='pag' class='form-control' placeholder='Ir a pagina' /></div>
	<div class='col-xs-1'><button type='button' class='btn divb btn-block' onclick='ir();' >Ir</button></div>
	<div class='col-xs-1'><button type='button' class='btn divb btn-block' onclick='sgt();' >&gt;&gt;</button></div>
	</div>
	<center><div>Pagina: <span id='pag_msj' ></span> de <span id='pag_total' ></span></div></center><script> 
iniciar(); </script>";
	mysqli_free_result($rs);
	mysqli_close($link);
	exit();
} else if(isset($_GET['eliminar'])){
	if($_GET['eliminar'] != ""){
		if($_SESSION['tipo'] == 2){
			$query ="DELETE FROM `anuncio` WHERE `id_anuncio`='{$_GET['eliminar']}'";
			mysqli_query($link, $query) or die ("No se pudo eliminar el anuncio: ".mysqli_error($link));
			mysqli_close($link);
			echo "<script> alert('Anuncio eliminado exitosamente'); location.href='s_admin/'</script>";
			exit();
		} else {
			mysqli_close($link);
			echo "<script>
				alert('usted no tiene permisos de Admin');
				location.href='./';
			</script>";
			exit();
		}
	} else {
		mysqli_close($link);
		echo "<script>
				alert('No se ha pasado valor al parametro');
				location.href='./';
			</script>";
		exit();
	}
} else if(isset($_GET['ver_mas'])){
	if($_GET['ver_mas'] != ""){
		$query = "SELECT `anuncio`.`id_anuncio`,`anuncio`.`fecha`,`anuncio`.`titulo`,`anuncio`.`fk_tipo`,`anuncio`.`direccion`,`anuncio`.`descripcion`,`anuncio`.`precio`,`accion_dato`.`id_accion`,`accion_dato`.`nombre_accion`,`usuario`.`nombre`,`usuario`.`id_usuario`,`usuario`.`apellido`,`tipo_inmueble`.`id_tipo`,`tipo_inmueble`.`nombre` as tipo_n FROM `{$db}`.`anuncio` INNER JOIN `{$db}`.`usuario` INNER JOIN `{$db}`.`accion_dato` INNER JOIN `{$db}`.`tipo_inmueble` WHERE `anuncio`.`fk_creador`=`usuario`.`id_usuario` AND `anuncio`.`fk_accion`=`accion_dato`.`id_accion` AND `id_anuncio`='{$_GET['ver_mas']}'";
		$resultado = mysqli_query($link, $query) or die ('Error de al consultar la base de datos: ' . mysqli_error($link));
		$dato = mysqli_fetch_assoc($resultado);
		mysqli_free_result($resultado);
		mysqli_close($link);
		echo "<br/><center><h2>{$dato['titulo']}</h2></center><h4>{$dato['tipo_n']}<br/>Direccion: {$dato['direccion']}<br/>";
		if($dato['descripcion'] != ""){
			echo "Descripcion: {$dato['descripcion']}<br/>";
		}
		echo "Precio: {$dato['precio']} Para {$dato['nombre_accion']}<br/>Publicado por: {$dato['nombre']} {$dato['apellido']}<br/>Fecha: {$dato['fecha']} </h4>";
		for($x=1; $x<11; $x++){
			$ruta ="anuncio/{$dato['id_anuncio']}/{$x}";
			if(is_file($ruta)){
				echo "<img src='{$ruta}' style='width:33%; height:250px;' /> ";
			}
		}
		exit();
	} else {
		echo "<script> alert('Parametro no valido'); location.href='./'; </script>";
		exit();
	}
} else {
	echo "<script> alert('Se requiere un parametro'); location.href='./'; </script>";
	mysqli_close($link);
	exit();
}
mysqli_close($link);
exit();