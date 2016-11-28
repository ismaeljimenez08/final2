function validarcampos(){
	mensaje = document.getElementById('msj');
	mensaje.innerHTML = "";
	campos = document.getElementsByTagName('input');
	for(x=0; x<campos.length; x++){
		if(campos[x].getAttribute('class') == "obl form-control"){
			if(campos[x].value == ""){
				mensaje.innerHTML = "<span class='glyphicon glyphicon-warning-sign'></span> Debe completar los campos obligatorios!";
				return false;
				break;
			}
		}
	}
	return true;
}
function validarclaves(){
	mensaje = document.getElementById('msj');
	mensaje.innerHTML = "";
	c1 = document.getElementById('c1');
	c2 = document.getElementById('c2');
	if(c1.value != c2.value){
		mensaje.innerHTML = "<span class='glyphicon glyphicon-warning-sign'></span> Las contraseñas no coinciden!";
	}
}
function contador(){
	item = document.getElementById("textarea");
	mensaje = document.getElementById("msn_desc");
	mensaje.innerHTML = "";
	mensaje.innerHTML = item.value.length+"/250";
}
res = document.getElementsByName('res');
function ocultar_todo(){
	total = res.length;
	tot_msj = document.getElementById("pag_total");
	tot_msj.innerHTML = "";
	tot_msj.innerHTML = total;
	for(x=0;x<res.length;x++){
		$("#"+(x+1)).hide();
	}
}
function iniciar(){
msj_actual = document.getElementById("pag_msj");
msj_actual.innerHTML = "";
msj_actual.innerHTML = "1";
ocultar_todo();
$("#1").show();
document.getElementById('pag').value = "1";
}
function sgt(){
	valor = document.getElementById('pag').value;
	valor++;
	pag = document.getElementById(valor);
	if(pag !== null){
		msj_actual = document.getElementById("pag_msj");
		msj_actual.innerHTML ="";
		msj_actual.innerHTML =valor;
		ocultar_todo();
		document.getElementById('pag').value = valor;
		$("#"+valor).show();
	} else {
		alert('La pagina solicitada no existe');
	}
}
function ant(){
	valor = document.getElementById('pag').value;
	valor--;
	pag = document.getElementById(valor);
	if(pag !== null){
		msj_actual = document.getElementById("pag_msj");
		msj_actual.innerHTML ="";
		msj_actual.innerHTML =valor;
		ocultar_todo();
		document.getElementById('pag').value = valor;
		$("#"+valor).show();
	} else {
		alert('La pagina solicitada no existe');
	}
}
function ir(){
	valor = document.getElementById('pag').value;
	pag = document.getElementById("#"+valor);
	if(pag !== null){
		msj_actual = document.getElementById("pag_msj");
		msj_actual.innerHTML ="";
		msj_actual.innerHTML =valor;
		ocultar_todo();
		$("#"+valor).show();
	} else {
		alert('La pagina solicitada no existe');
	}
}
function m_mapa(){
	$("#map").show();
	$("#normal").hide();
}
function m_normal(){
	$("#map").hide();
	$("#normal").show();
}