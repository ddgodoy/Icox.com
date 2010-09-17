function colorMn(celda, accion){
	document.getElementById(celda).style.color = accion==1?'#EBEBE9':'#3A4E5C';
}
/*-------------------------------------------------------------------------*/
function colorIz(celda, accion){
	document.getElementById(celda).style.color = accion==1?'#6D7A84':'#666666';
}
/*-------------------------------------------------------------------------*/
function goTo(pagina){
	document.location = pagina;
}
function downLoad(archivo){
	location.href = archivo;
}