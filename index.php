<?php
include "recursos/layout.php";
$p = new plantilla();
require "recursos/c_d.php";
$query  = "SELECT * FROM `{$db}`.`tipo_inmueble`";
$resultado = mysqli_query($link, $query);
errores($resultado);
$opciones = "";
while($opc = mysqli_fetch_assoc($resultado)){
$opciones = $opciones."<option value='{$opc['id_tipo']}' >{$opc['nombre']}</option>";
}
mysqli_free_result($resultado);
/* 
modo normal falta poner los marcadores de los sitios registrados */
?>
<div class="modal fade" id="busqueda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Busqueda Avanzada</h4>
      </div>
	<form method="get" action="detalle.php" >
      <div class="modal-body">
		<input type="text" placeholder="Buscar por titulo" class="form-control" name="buscar" /><br/><select name="filtro" class="form-control" ><option selected="selected" value="" >-- Agregar Filtro --</option><?php echo $opciones; ?></select><br/><button name="busqueda" value="true" type="submit" class="btn divb btn-block" ><span class="glyphicon glyphicon-search"></span> Buscar</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" ></span> Cerrar</button>
      </div>
	 </form>
    </div>
  </div>
</div>
<div class="swiper-container" >
	<div class="swiper-wrapper">
		<div class="swiper-slide" style="background-image:url('header/01.jpg');" ><img src="inmobi-2.png" /></div>
		<div class="swiper-slide" style="background-image:url('header/02.jpg');" ><img src="inmobi-2.png" /></div>
		<div class="swiper-slide" style="background-image:url('header/03.jpg');" ><img src="inmobi-2.png" /></div>
		<div class="swiper-slide" style="background-image:url('header/04.jpg');" ><img src="inmobi-2.png" /></div>
	</div>
	<div class="swiper-pagination swiper-pagination-white"></div>
	<div class="swiper-button-next swiper-button-white"></div>
	<div class="swiper-button-prev swiper-button-white"></div>
</div>
<br/>
<div role="button" onclick="m_normal();" class="divb col col-xs-3" >Anuncios Recientes</div>
<div class="divv col col-xs-1"></div>
<div role="button" onclick="m_mapa();" class="divb col col-xs-3" >Ver Modo Mapa</div>
<div class="divv col col-xs-1"></div>
<div role="button" class="divb col col-xs-4" data-toggle="modal" data-target="#busqueda" >Busqueda Avanzada</div>
<br/><br/><br/><hr/>
<div id="map" class='rela2'></div>
<div id="normal" >
	<div class='row' >
<?php
$query = "SELECT * FROM `{$db}`.`anuncio` INNER JOIN `{$db}`.`usuario` INNER JOIN `{$db}`.`accion_dato` WHERE `anuncio`.`fk_creador`=`usuario`.`id_usuario` AND `anuncio`.`fk_accion`=`accion_dato`.`id_accion` AND `anuncio`.`estado`='1' ORDER BY `anuncio`.`fecha` DESC ";
$resultado = mysqli_query($link, $query);
errores($resultado);
$contador = $count =1;
$primero = false;
echo "<div name='res' id='1' >";
while($fila = mysqli_fetch_assoc($resultado)){
if($count == 10){
$count = 1;
}
if($primero AND $count ==1){
	$contador++;
	echo "</div><div id='{$contador}' name='res' >";
}
	$primero = true;
	echo "<div class=' col col-xs-4'>
	<img src='anuncio/{$fila['id_anuncio']}/1' width='100%' height='200px' /><br/>Titulo: {$fila['titulo']} <br/>Precio: {$fila['precio']} para {$fila['nombre_accion']}<br/> Publicado por: {$fila['nombre']} {$fila['apellido']}<br/>Dia: {$fila['fecha']}<br/><a href='detalle.php?ver_mas={$fila['id_anuncio']}' >Ver mas</a></div>";
	$count++;
}
mysqli_free_result($resultado);
mysqli_close($link);
?>
	</div></div><br/>
	<div class="row"><div class="col-xs-1"><button type="button" class="btn divb btn-block" onclick="ant();" >&lt;&lt;</button></div>
	<div class="col-xs-2"><input id="pag" class="form-control" placeholder="Ir a pagina" /></div>
	<div class="col-xs-1"><button type="button" class="btn divb btn-block" onclick="ir();" >Ir</button></div>
	<div class="col-xs-1"><button type="button" class="btn divb btn-block" onclick="sgt();" >&gt;&gt;</button></div>
	</div>
	<center><div>Pagina: <span id="pag_msj" ></span> de <span id="pag_total" ></span></div></center>
</div>
<br/>
<script>
datos = {};
function myMap() {
	var mapCanvas = document.getElementById("map");
	var mapOptions = {
	center: new google.maps.LatLng(18.521283, -69.883229), 
	zoom: 8
	}
	var map = new google.maps.Map(mapCanvas, mapOptions);
	$.ajax({
		url: 'ajax.php?get_lat_lng=true'
	}).done(function(dd){
	datos = JSON.parse(dd);
		for(x =0; x<datos.id.length; x++){
			var latitud= (datos.lat[x]);
			var longitud = (datos.lng[x]);
			var coorMarcador = new google.maps.LatLng(latitud,longitud);
			var marcador = new google.maps.Marker({
				position: coorMarcador,
				map: map,
			});
			var infowindow = new google.maps.InfoWindow({
				content:"<h4>"+datos.titulo[x]+"</h4><img src='anuncio/"+datos.id[x]+"/1' style='width:120px; height:120px;'><br/><a href='detalle.php?ver_mas="+datos.id[x]+"' >Ver Mas</a>",
			});
			marcador.addListener('click', function() {
				infowindow.open(map,this); 
			});
		}
	});
}
iniciar();
$("#normal").hide();
</script>
<script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=AIzaSyCM-U-spzSYv_c3AEG6EycOw0EFMLUqGn4" ></script>