<?php
session_start();
class plantilla{
	function __construct(){
if($_SESSION['mensaje'] != ""){
	echo "<script> alert('{$_SESSION['mensaje']}') </script>";
$_SESSION['mensaje'] = "";
}
?>
<!DOCTYPE html>
<html lang="ES" >
	<head>
		<title>INMOBI ITLA</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="recursos/css/index.css" />
		<link type="text/css" rel="stylesheet" href="recursos/bootstrap/css/bootstrap.min.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="recursos/Swiper-3.3.1/dist/css/swiper.min.css" />
		<script src="recursos/js/jquery-2.2.0.min.js" ></script>
		<script src="recursos/js/index.js" ></script>
		<script src="recursos/bootstrap/js/bootstrap.min.js" ></script>
		<link href="recursos/logo.ico" rel="shortcut icon" />
	</head>
	<body class="letra fondo" <?php if($_GET['view'] == "mapa") { echo "onload='initialize();'"; } ?> >
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
			<div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="./"><span class="glyphicon glyphicon-home" ></span> INMOBI ITLA</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
		<?php 
		if($_SESSION['activo']){
			if($_SESSION['tipo'] == "2"){ echo "<li><a href='s_admin/' ><span class='glyphicon glyphicon-cog' ></span> Administrar</a></li> "; } ?>
						<li><a href="user.php"><span class="glyphicon glyphicon-tasks" ></span> Gestionar Anuncios</a></li>
						<li><a href="publicar.php"><span class="glyphicon glyphicon-cloud-upload" ></span> Publicar Anuncio</a></li>
					</ul>
				    <ul class="nav navbar-nav navbar-right">
						<li><a href="logout.php"><span class="glyphicon glyphicon-log-out" ></span> Cerrar Sesion</a></li>
					</ul>
				</div>
<?php } else { ?>
						<li><a href="registrar.php"><span class="glyphicon glyphicon-wrench" ></span> Registrarse</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
					<li><a role="button" data-toggle="modal" data-target="#myModal" >¿Tienes cuenta? Iniciar sesión</a></li>
					</ul>
				</div>
		<?php } ?>
			</div>
		</nav>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Iniciar Sesion</h4>
      </div>
	<form method="post" action="verificacion.php" >
      <div class="modal-body">
		<div class="form-group has-feedback">
			<label>Correo</label>
			<input class="form-control" type="text" name="correo" placeholder="Email..." />
			<span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
		</div>
		<div class="form-group has-feedback">
			<label>Contraseña</label>
			<input class="form-control" type="password" name="clave" placeholder="Contraseña..." />
			<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove" ></span> Cerrar</button>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-log-in" ></span> Iniciar Sesion</button>
      </div>
	 </form>
    </div>
  </div>
</div>
		<div class="container" >	
<?php
	}
	function __destruct(){
?>
		</div>
		<footer class="piedepagina" >
			<center>
				<h3 class="letracolor" >Derechos Reservados 2016</h3>
				<h4 class="colordos" >Proyecto Final | Programacion Web</h4>
				<p class="letracolor" >Prof.: Amadis Suarez</p>
			</center>
		</footer>
	<script src="recursos/Swiper-3.3.1/dist/js/swiper.min.js"></script>
	<script>
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true,
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			spaceBetween: 30,
			effect: 'fade',
			autoplayDisableOnInteraction: false,
			autoplay: 2000
		});
	</script>
	</body>
</html>
<?php
	}
}
?>