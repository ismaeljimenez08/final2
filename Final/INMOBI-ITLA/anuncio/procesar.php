<?php
session_start();
if($_POST['titulo'] != ""){
require "../recursos/c_d.php";
	if($_FILES['foto']['size'] > 0){
		$query = "INSERT INTO `{$db}`.`anuncio` (titulo,direccion,fk_tipo,precio,fk_accion,descripcion,fecha,cant_fotos,fk_creador,estado,latitud,longitud) values ('{$_POST['titulo']}','{$_POST['direccion']}','{$_POST['tipo']}','{$_POST['precio']}','{$_POST['accion']}','{$_POST['descripcion']}',now(),'1','{$_SESSION['id_usuario']}','1','{$_POST['latitud']}','{$_POST['longitud']}')";
		$uploadedfileload = true;
		$uploadedfile_size=$_FILES['foto']['size'];
		echo $_FILES['foto']['name'];
		if ($_FILES['foto']['size']>2000000) {
			$msg=$msg."El archivo es mayor que 2000KB, debes reduzcirlo antes de subirlo<br/>";
			$uploadedfileload=false;
		}
		if (!($_FILES['foto']['type'] =="image/jpeg" OR $_FILES['foto']['type'] == "image/png")){
			$msg=$msg." Tu archivo no tiene un formato permitido. Debe ser *.jpg o *.PNG<br/>";
			$uploadedfileload = false;
		}
		$file_name=$_FILES['foto']['name'];
		if($uploadedfileload){
			mysqliz_query($link, $query) or die("Error al insertar los datos ".mysqli_error($link));
			$query = "SELECT id_anuncio FROM `{$db}`.`anuncio` ORDER BY id_anuncio DESC LIMIT 1";
			$rs = mysqli_query($link, $query);
			$dir = mysqli_fetch_assoc($rs);
			mysqli_free_result($rs);
			$add="{$dir['id_anuncio']}/1";
			if(!is_dir($dir['id_anuncio'])){
				mkdir($dir['id_anuncio']);
				if(move_uploaded_file($_FILES['foto']['tmp_name'], $add)){
					echo "<script> alert('Ha sido subido satisfactoriamente'); </script>";
				} else {
				//	echo "<script> alert('Error al subir la foto'); </script>";
				}
			} else {
			//echo "<script> alert('Error al subir la foto'); </script>";
			}
			
		} else {
			echo $msg;
		}
	} else {
		echo "<script> alert('Debe subir una foto para publicar el anuncio'); </script>";
	}
mysqli_close($link);
header("Location:../publicar.php");
}
if($_POST['foto_anuncio'] != ""){
	if($_FILES[$_POST['foto_anuncio']]['size'] > 0){
		$uploadedfileload = true;
		$uploadedfile_size=$_FILES[$_POST['foto_anuncio']]['size'];
		if ($_FILES[$_POST['foto_anuncio']]['size']>2000000) {
			$msg=$msg."El archivo es mayor que 2000KB, debes reduzcirlo antes de subirlo<br/>";
			$uploadedfileload=false;
		}
		if (!($_FILES[$_POST['foto_anuncio']]['type'] =="image/jpeg" OR $_FILES[$_POST['foto_anuncio']]['type'] == "image/png")){
			$msg=$msg." Tu archivo no tiene un formato permitido. Debe ser *.jpg o *.PNG<br/>";
			$uploadedfileload = false;
		}
		$file_name=$_FILES[$_POST['foto_anuncio']]['name'];
		if($uploadedfileload){
			$add="{$_POST['direccion']}/{$_POST['foto_anuncio']}";
			if(is_dir($_POST['direccion'])){
				if(move_uploaded_file($_FILES[$_POST['foto_anuncio']]['tmp_name'], $add)){
					echo "<script> alert('Ha sido subido satisfactoriamente'); </script>";
				} else {
				//	echo "<script> alert('Error al subir la foto'); </script>";
				}
			} else {
			//echo "<script> alert('Error al subir la foto'); </script>";
			}
			
		} else {
			echo $msg;
		}
	}
header("Location:../detalle.php?ver_mas={$_POST['direccion']}");
}
?>