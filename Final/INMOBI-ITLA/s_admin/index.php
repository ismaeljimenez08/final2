<?php
session_start();
if($_SESSION['tipo'] != "2"){
	header("Location:../");
	exit();
}
require "../recursos/c_d.php";
?>
<!DOCTYPE html>
<html lang="ES" >
	<head>
		<title>INMOBI ITLA</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="../recursos/css/index.css" />
		<link type="text/css" rel="stylesheet" href="../recursos/bootstrap/css/bootstrap.min.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<script src="../recursos/js/jquery-2.2.0.min.js" ></script>
		<script src="../recursos/js/index.js" ></script>
		<script src="../recursos/bootstrap/js/bootstrap.min.js" ></script>
		<link href="../recursos/logo.ico" rel="shortcut icon" />
		<style>
.tomaya{
	height:450px;
}
		</style>
	</head>
	<body class="letra fondo" >
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
			<div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href=".././"><span class="glyphicon glyphicon-home" ></span> INMOBI ITLA<!--<img src="inmobi.png" height="40px" />--></a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href='./' ><span class='glyphicon glyphicon-cog' ></span> Administrar</a></li>
						<li><a href="../user.php"><span class="glyphicon glyphicon-tasks" ></span> Gestionar Anuncios</a></li>
						<li><a href="../publicar.php"><span class="glyphicon glyphicon-cloud-upload" ></span> Publicar Anuncio</a></li>
					</ul>
				    <ul class="nav navbar-nav navbar-right">
						<li><a href="../logout.php"><span class="glyphicon glyphicon-log-out" ></span> Cerrar Sesion</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container" >	
<br/>
<button class="btn divb" onclick="a_anuncios();" type="button" >Anuncios</button>
<button class="btn divb" onclick="u_usuario();" type="button" >Eliminar Usuarios</button>
<button class="btn divb" onclick="tipo_inmueble();" type="button" >Tipo de Inmuebles</button>
<button class="btn divb" onclick="e_acciones();" type="button" >Editar Acciones</button>
<button class="btn divb" onclick="r_admin();" type="button" >Registrar Admin</button>
<div id="anuncios"><br/><br/><br/>
<center><h3>Anuncios</h3></center>
<?php
$query = "SELECT * FROM `{$db}`.`anuncio` INNER JOIN `{$db}`.`usuario` INNER JOIN `{$db}`.`accion_dato` WHERE `anuncio`.`fk_creador`=`usuario`.`id_usuario` AND `anuncio`.`fk_accion`=`accion_dato`.`id_accion` AND `anuncio`.`estado`='1' ORDER BY `anuncio`.`fecha` DESC ";
$resultado = mysqli_query($link, $query);
errores($resultado);
$contador = $count =1;
$primero = false;
echo "<div class='row' name='res' id='1' >";
while($fila = mysqli_fetch_assoc($resultado)){
if($count == 10){
$count = 1;
}
if($primero AND $count ==1){
	$contador++;
	echo "</div><div class='row' id='{$contador}' name='res' >";
}
	$primero = true;
	echo "<div class='col col-xs-4'>
	<img src='../anuncio/{$fila['id_anuncio']}/1' width='100%' height='200px' /><br/>Titulo: {$fila['titulo']} <br/>Precio: {$fila['precio']} para {$fila['nombre_accion']}<br/> Publicado por: {$fila['nombre']} {$fila['apellido']}<br/>Dia: {$fila['fecha']}<br/><a type='button' class='btn divb' href='../detalle.php?eliminar={$fila['id_anuncio']}' >Eliminar</a></div>";
	$count++;
}
mysqli_free_result($resultado);
?>
</div><br/>
<div class="row" ><div class="col-xs-1"><button type="button" class="btn divb btn-block" onclick="ant();" >&lt;&lt;</button></div>
	<div class="col-xs-2"><input id="pag" class="form-control" placeholder="Ir a pagina" /></div>
	<div class="col-xs-1"><button type="button" class="btn divb btn-block" onclick="ir();" >Ir</button></div>
	<div class="col-xs-1"><button type="button" class="btn divb btn-block" onclick="sgt();" >&gt;&gt;</button></div>
	<div class="col col-xs-7" ></div>
	</div><br/>
	<center><div>Pagina: <span id="pag_msj" ></span> de <span id="pag_total" ></span></div></center>
</div>
<div id="usuarios" class="tomaya" >
	<form method="post" action="../ajax.php" >
	<br/><br/><br/>
		<center><h3>Eliminar Usuario</h3></center><div class="row">
		<div class="form-group" ><div class="col-xs-4" ></div><div class="col-xs-1" ><input type="radio" name="filtro" value="2" /></div><div class="col-xs-3" ><input type="text" name="cedula" class="form-control" placeholder="por Cedula" /></div><div class="col-xs-4"></div></div></div><br/><div class="row">
		<div class="form-group" ><div class="col-xs-4" ></div><div class="col-xs-1" ><input type="radio" name="filtro" checked="checked" value="1" /></div><div class="col-xs-3" ><input type="email" class="form-control" name="correo" placeholder="por Email" /></div><div class="col-xs-4" ></div></div></div><br/>
		<div class="row" ><div class="col-xs-4"></div><div class="col-xs-4"><button class="btn divb btn-block" onclick="return confirm('Si se elimina este usuario, Tambien se eliminaran los anuncios publicados por el mismo, Desea continuar?');" type="submit" >Eliminar</button></div><div class="col-xs-4"></div></div>
	</form>
</div>
<div id="tipo_inmueble" class="tomaya" >
	<br/><br/><br/><center><h3>Tipo de inmueble</h3></center><div class="row"><div class="col-xs-4"></div><div class="col-xs-4">
	<form method="post" action="../ajax.php" >
	<input type="text" class="form-control" name="tipo" placeholder="Tipo de inmueble"/><br/>
	<select class="form-control" name="tipo2" >
<?php
	$query = "SELECT * FROM `{$db}`.`tipo_inmueble`";
	$resultado = mysqli_query($link, $query);
	errores($resultado);
	while($fila =mysqli_fetch_assoc($resultado)){
		echo "<option value='{$fila['id_tipo']}' >{$fila['nombre']}</option>";
	}
	mysqli_free_result($resultado);
?>
	</select><br/>
	<button class="btn divb btn-block" name="enviado" value="a" type="submit">Agregar</button><br/>
	<button class="btn divb btn-block" name="enviado" value="e" type="submit">Editar</button><br/>
	</form></div><div class="col-xs-4"></div>
</div>
</div>
<div id="acciones" class="tomaya" >
	<br/><br/><br/><center><h3>Acciones</h3></center><div class="row"><div class="col-xs-4"></div><div class="col-xs-4">
	<form method="post" action="../ajax.php" ><input type="text" class="form-control" name="accion" placeholder="Acciones"/><br/>
<select name="accion2" class="form-control" >
<?php
$query = "SELECT * FROM `{$db}`.`accion_dato`";
	$resultado = mysqli_query($link, $query);
	errores($resultado);
	while($fila =mysqli_fetch_assoc($resultado)){
		echo "<option value='{$fila['id_accion']}' >{$fila['nombre_accion']}</option>";
	}
	mysqli_free_result($resultado);
	mysqli_close($link);
?>
	</select><br/>
	<button class="btn divb btn-block" name="enviado1" value="a" type="submit">Agregar</button><br/>
	<button class="btn divb btn-block" name="enviado1" value="e" type="submit">Editar</button></form>
	</div><div class="col-xs-4"></div>
	</div>
</div>
<div id="registro" ><br/><br/><br/>
	<center><h3>Registro</h3></center><hr/>
	<form method="post" action="../registro.php" >
	<div class="row">
		<div class="col col-xs-4" >
			<div class="form-group"><input type="text" class="obl form-control" maxlength="30" name="nombre" placeholder="Nombre" /></div><div class="form-group">
			<input type="text" class="obl form-control" maxlength="30" name="apellido" placeholder="Apellido" /></div><div class="form-group">
			<input type="text" class="obl form-control" name="cedula" maxlength="13" placeholder="Cedula" /></div>
		</div>
		<div class="col col-xs-4" >
			<div class="form-group"><input type="email" class="obl form-control" maxlength="30" name="correo" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Despues del texto del '@' lleva '.' y la extension del dominio. ex.:(.com)" /></div><div class="form-group">
			<input type="password" maxlength="50" class="obl form-control" onkeyup="validarclaves();" id="c1" name="clave1" placeholder="Contraseña" /></div><div class="form-group">
			<input type="password" maxlength="50" class="obl form-control" onkeyup="validarclaves();" id="c2" name="clave2" placeholder="Repetir Contraseña" /></div>
		</div>
		<div class="col col-xs-4" >
			<div class="form-group"><input type="text" class="obl form-control" maxlength="15" name="celular" placeholder="Celular" /></div><div class="form-group"><select name="tipo" class="form-control">
			<option value="2">Admin</option>
			<option value="1">Normal</option>
			</select></div><div class="form-group"><input type="text" class="form-control" maxlength="15" name="telefono" placeholder="Telefono (Opcional)" /></div>
		</div>
		<div class="col col-xs-8" >
			<div class="form-group"><textarea class="form-control" id="textarea" maxlength="250" name="mas_info" placeholder="Mas informacion... (Opcional)" onkeyup="contador();" ></textarea><span id="msn_desc" >0/250</span></div>
		</div>
		<div class="col col-xs-4" >
			<div class="form-group">
			<input type="text" class="form-control" maxlength="30" name="fax" placeholder="Fax (Opcional)" /></div>
			<div class="form-group"><button class="btn divb" onclick="return validarcampos();" type="submit"  >Registrar</button></div>
		</div>
	</div>
	</form>
<span id="msj" ></span>
</div><br/>
		</div>
		<footer class="piedepagina" >
			<center>
				<h3 class="letracolor" >Derechos Reservados 2016</h3>
				<h4 class="colordos" >Proyecto Final | Programacion Web</h4>
				<p class="letracolor" >Prof.: Amadis Suarez</p>
			</center>
		</footer>
	<script>
an = $("#anuncios");
us = $("#usuarios");
t_i = $("#tipo_inmueble");
ac = $("#acciones");
re = $("#registro");
us.hide();
t_i.hide();
ac.hide();
re.hide();
function u_usuario(){
an.hide();
us.show();
t_i.hide();
ac.hide();
re.hide();
}
function tipo_inmueble(){
an.hide();
us.hide();
t_i.show();
ac.hide();
re.hide();
}
function e_acciones(){
an.hide();
us.hide();
t_i.hide();
ac.show();
re.hide();
}
function r_admin(){
an.hide();
us.hide();
t_i.hide();
ac.hide();
re.show();
}
function a_anuncios(){
an.show();
us.hide();
t_i.hide();
ac.hide();
re.hide();
}
iniciar();
	</script>
	</body>
</html>