<?php
include "recursos/layout.php";
$p = new plantilla();
?>
<br/>
<h3>Registro</h3>
<hr/>
<form method="post" action="registro.php" >
	<div class="row">
		<div class="col col-xs-4" >
			<div class="form-group"><input type="text" class="obl form-control" maxlength="30" name="nombre" placeholder="Nombre" /></div><div class="form-group">
			<input type="text" class="obl form-control" maxlength="30" name="apellido" placeholder="Apellido" /></div><div class="form-group">
			<input type="text" class="obl form-control" name="cedula" maxlength="13" placeholder="Cedula" /></div>
		</div>
		<div class="col col-xs-4" >
			<div class="form-group"><input type="email" class="obl form-control" maxlength="30" name="correo" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Despues del texto del '@' lleva '.' y la extension del dominio. ex.:(.com)" /></div><div class="form-group">
			<input type="password" maxlength="50" class="obl form-control" title="La Contraseña debe tener Seis o Mas Caracteres" onkeyup="validarclaves();" id="c1" name="clave1" placeholder="Contraseña" /></div><div class="form-group">
			<input type="password" maxlength="50" class="obl form-control" title="La Contraseña debe tener Seis o Mas Caracteres" onkeyup="validarclaves();" id="c2" name="clave2" placeholder="Repetir Contraseña" /></div>
		</div>
		<div class="col col-xs-4" >
			<div class="form-group"><input type="text" class="obl form-control" maxlength="15" name="celular" placeholder="Celular" /></div><div class="form-group"><input type="text" class="form-control" maxlength="15" name="telefono" placeholder="Telefono (Opcional)" /></div><div class="form-group">
			<input type="text" class="form-control" maxlength="30" name="fax" placeholder="Fax (Opcional)" /></div>
		</div>
		<div class="col col-xs-8" >
			<div class="form-group"><textarea class="form-control" id="textarea" maxlength="250" name="mas_info" placeholder="Mas informacion... (Opcional)" onkeyup="contador();" ></textarea><span id="msn_desc" >0/250</span></div>
		</div>
		<div class="col col-xs-4" >
			<div class="form-group"><button class="btn divb" onclick="return validarcampos();" type="submit"  >Registrar</button></div>
		</div>
	</div>
</form>
<span id="msj" ></span>
<br/>