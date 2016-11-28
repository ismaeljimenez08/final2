<?php
$_GET['view'] = "mapa";
include "recursos/layout.php";
$p = new plantilla();
if(!$_SESSION['activo']){
header("Location:./");
}
include "recursos/c_d.php";
// action = anuncio/procesar.php crear eso. para procesar fotos etc
?>
<style type="text/css"> 
  #map_canvas { height: 450px; width: 100%; } 
</style> 
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCM-U-spzSYv_c3AEG6EycOw0EFMLUqGn4"></script>
<script type="text/javascript">
function getCoords(marker){ 
    latd = document.getElementById("Ltd");
    lngd = document.getElementById("Lngt");
	latd.value = marker.getPosition().lat(); 
    lngd.value = marker.getPosition().lng(); 
} 
function initialize() { 
	var myLatlng = new google.maps.LatLng(18.521283,-69.883229); 
	var myOptions = { 
		zoom: 10, 
		center: myLatlng, 
		mapTypeId: google.maps.MapTypeId.ROADMAP, 
	} 
	var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
	marker = new google.maps.Marker({ 
		position: myLatlng, 
		draggable: true, 
		title:"Seleccione la ubicacion en el mapa" 
	}); 
	google.maps.event.addListener(marker, "dragend", function() { 
		getCoords(marker); 
	});  
	marker.setMap(map); 
	getCoords(marker); 
}
</script>
<h3>Publicar Anuncio</h3>
<form method="post" enctype="multipart/form-data" action="anuncio/procesar.php" >
<div class="row" >
	<div class="col col-xs-4"><div class="form-group" ><input class="obl form-control" type="text" name="titulo" placeholder="Titulo" /></div>
	<div class="form-group" ><input class="obl form-control" type="text" name="direccion" placeholder="Direccion" /></div>
	<div class="form-group" ><select class="form-control" name="tipo" placeholder="" >
		<option disabled="disabled" selected="selected" >-- Seleccione un tipo --</option>
<?php
	$query = "SELECT * FROM `{$db}`.`tipo_inmueble`";
	$resultado = mysqli_query($link, $query);
	errores($resultado);
	while($fila =mysqli_fetch_assoc($resultado)){
		echo "<option value='{$fila['id_tipo']}' >{$fila['nombre']}</option>";
	}
	mysqli_free_result($resultado);
?>
	</select></div><div class="form-group" ><input class="obl form-control" type="text" name="precio" placeholder="precio" /></div>
	<div class="form-group" ><select class="form-control" name="accion" >
		<option disabled="disabled" selected="selected" >-- Seleccione una accion --</option>
<?php
$query = "SELECT * FROM `{$db}`.`accion_dato`";
	$resultado = mysqli_query($link, $query);
	errores($resultado);
	while($fila =mysqli_fetch_assoc($resultado)){
		echo "<option value='{$fila['id_accion']}' >{$fila['nombre_accion']}</option>";
	}
	mysqli_free_result($resultado);
?>
	</select></div></div>
	<input id="Ltd" name="latitud" type="hidden" value="" />
	<input id="Lngt" name="longitud" type="hidden" value="" />
	<div class="col col-xs-8" ><div class="form-group" ><textarea class="form-control" id="textarea" type="text" name="descripcion" placeholder="Descripcion" onkeyup="contador();" maxlength="250" ></textarea><span id="msn_desc" >0/250</span></div>
	<div class="form-group" ><input type="file" accept="image/*" name="foto" required="required" /></div></div>
</div>
<span id="msj"></span>
<h3>Seleccione la ubicacion en el mapa:</h3>
<div id="map_canvas" ></div>
<br/>
<button class="btn divb" type="submit" onclick="return validarcampos();">Publicar</button>
</form>
<br/>
<?php
mysqli_close($link);