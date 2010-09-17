function addNuevoDNS()
{
	var celda = '';
	var iruta = document.getElementById('aux_dir_images').value;
  var tabla = document.getElementById('tbAlternativos');
	var fila  = tabla.insertRow(tabla.rows.length);

	celda = fila.insertCell(0);
	celda.style.paddingBottom = '5px';
	celda.innerHTML = 'DNS&nbsp;<input type="text" name="dns_alternativos[]" class="tmInput" style="width:200px;">';

	celda = fila.insertCell(1);
	celda.style.paddingBottom = '5px';
	celda.innerHTML = '&nbsp;IP&nbsp;<input type="text" name="ip_alternativos[]" class="tmInput" style="width:150px;">';

	celda = fila.insertCell(2);
	celda.innerHTML = '&nbsp;<img src="'+iruta+'borrar.gif" border="0" onclick="delRowAlternativo(this);" style="cursor:pointer;vertical-align:middle;"/>';
}

function delRowAlternativo(fila)
{
	fila.parentNode.parentNode.parentNode.deleteRow(fila.parentNode.parentNode.rowIndex);
}