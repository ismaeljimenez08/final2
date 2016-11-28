<?php
require "recursos/layout.php";
$p = new plantilla();
if(!$_SESSION['activo']){
	header("Location:./");
	exit();
}
require "recursos/c_d.php";
if(isset($_GET['eliminar'])){
	if($_GET['eliminar'] != ""){
		$query ="DELETE FROM `anuncio` WHERE `id_anuncio`='{$_GET['eliminar']}'";
		mysqli_query($link, $query) or die ("No se pudo eliminar el anuncio: ".mysqli_error($link));
	}
} else if($_GET['accion'] != "" AND $_GET['q'] != ""){
	if($_GET['accion'] == 1 OR $_GET['accion'] == 2){
		$query = "UPDATE `anuncio` SET `estado`='{$_GET['accion']}' WHERE `id_anuncio`='{$_GET['q']}'";
		mysqli_query($link, $query) or die ("No se pudo actualizar el estado: ".mysqli_error($link));
	}
} else if(isset($_GET['editar'])){
	if($_GET['editar'] != ""){
		if(!$_POST['titulo']){
		$query ="SELECT * FROM `anuncio` WHERE `id_anuncio`='{$_GET['editar']}'";
		$rs=mysqli_query($link, $query);
		errores($rs);
		$fila=mysqli_fetch_assoc($rs);
		mysqli_free_result($rs);
?>
<div class="row" >
<h3>Panel de edicion</h3>
<form method="post" action="" >
<div class="container">
	<div class="form-group"><input class="obl form-control" type="text" value="<?php echo $fila['titulo']; ?>" name="titulo" placeholder="Titulo" /></div>
	<div class="form-group"><input class="obl form-control" type="text" value="<?php echo $fila['direccion']; ?>" name="direccion" placeholder="Direccion" /></div>
	<div class="form-group"><select class="form-control" name="tipo" placeholder="" >
<?php
	$query = "SELECT * FROM `{$db}`.`tipo_inmueble`";
	$resultado = mysqli_query($link, $query);
	errores($resultado);
	while($filas =mysqli_fetch_assoc($resultado)){
		if($filas['id_tipo'] == $fila['fk_tipo']){
			echo "<option value='{$filas['id_tipo']}' selected='selected' >{$filas['nombre']}</option>";
		} else {
			echo "<option value='{$filas['id_tipo']}' >{$filas['nombre']}</option>";
		}
	}
	mysqli_free_result($resultado);
?>
	</select></div>
	<div class="form-group"><input class="obl form-control" value="<?php echo $fila['precio']; ?>" type="text" name="precio" placeholder="precio" /></div>
	<div class="form-group"><select class="form-control" name="accion" >
<?php
$query = "SELECT * FROM `{$db}`.`accion_dato`";
	$resultado = mysqli_query($link, $query);
	errores($resultado);
	while($filas =mysqli_fetch_assoc($resultado)){
		if($filas['id_accion'] == $fila['fk_accion']){
			echo "<option selected='selected' value='{$filas['id_accion']}' >{$filas['nombre_accion']}</option>";
		} else {
			echo "<option value='{$filas['id_accion']}' >{$filas['nombre_accion']}</option>";
		}
	}
	mysqli_free_result($resultado);
?>
	</select></div>
	<div class="form-group"><textarea class="form-control" id="textarea" type="text" name="descripcion" placeholder="Descripcion" onkeyup="contador();" ><?php echo $fila['descripcion']; ?></textarea></div><span id="msn_desc" >0/250</span>
	<div class="form-group"><button class="btn divb" type="submit" onclick="return validarcampos();">Actualizar</button></div></div>
</form>
<span id="msj"></span>
<br/>
</div>
<?php
		} else {
			$query = "UPDATE `anuncio` SET `titulo`='{$_POST['titulo']}',`direccion`='{$_POST['direccion']}',`fk_tipo`='{$_POST['tipo']}',`precio`='{$_POST['precio']}',`fk_accion`='{$_POST['accion']}',`descripcion`='{$_POST['descripcion']}' WHERE `id_anuncio`='{$_GET['editar']}'";
			mysqli_query($link, $query) or die ('Error al actualizar los datos: ' . mysqli_error($link));
		}
	}
}
if(isset($_GET['subir'])){
	if($_GET['subir'] != ""){
		echo "<h2>Subir Mas Fotos</h2><form method='post' action='anuncio/procesar.php' enctype='multipart/form-data' ><input type='hidden' name='direccion' value='{$_GET['subir']}' />";
		$x;
		for($x=1;$x<11;$x++){
			if(!is_file("anuncio/{$_GET['subir']}/{$x}")){
				echo "<input type='file' name='{$x}' accept='images/*' /><br/>";
				break;
			}
		}
		echo "<button class='btn divb' type='submit' value='{$x}' name='foto_anuncio' >Subir Fotos</button></p>Maximo de fotos en el servidor 10</p></form>";
	}
}
?>
<h3>Mis Anuncios</h3>
<div class='row'>
<?php
//* El usuario una vez inicie sesión puede ver sus anuncios publicados, editarlos o desactivarlos.
$query="SELECT id_anuncio,titulo,estado FROM `anuncio` WHERE `fk_creador`='{$_SESSION['id_usuario']}'";
$rs =mysqli_query($link, $query);
while($fila=mysqli_fetch_assoc($rs)){
	echo "<div class='col col-xs-4'>
			<img src='anuncio/{$fila['id_anuncio']}/1' width='100%' height='250px' />Titulo: {$fila['titulo']}<br/><a href='?editar={$fila['id_anuncio']}' type='button' class='btn divb' >Editar</a> <a type='button' class='btn divb' href='?subir={$fila['id_anuncio']}' >Subir fotos</a> <a href='?eliminar={$fila['id_anuncio']}' onclick='return confirm(\"Seguro que desea Eliminar este anuncio?\");' type='button' class='btn divb' >Eliminar</a> ";
	if($fila['estado'] == '1'){
		echo "<a type='button' class='btn divb' href='?accion=2&q={$fila['id_anuncio']}' >Desactivar</a>";
	} else {
		echo "<a type='button' class='btn divb' href='?accion=1&q={$fila['id_anuncio']}' >Activar</a>";
	}
	echo "</div>";
}
mysqli_free_result($rs);
mysqli_close($link);
?>
</div>
<br/>
