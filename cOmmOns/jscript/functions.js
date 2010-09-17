function confirmLink(theLink, theText){
    if (theText == '' || typeof(window.opera) != 'undefined') {return true;}
    var is_confirmed = confirm(theText);
    if (is_confirmed) {
        theLink.href += '&confirmado=1';
    }
    return is_confirmed;
}
//------------------------------------------------------------------------
function doPreview(wich, where){
	var objFile = document.getElementById(wich); //imagen
	var objImg = document.getElementById(where); //preview

	objImg.src = objFile.value;
}
//------------------------------------------------------------------------
function openWin(ventana,popW,popH,nombre_ventana){
	if (nombre_ventana == undefined){var nom = 'Window';} else {var nom = nombre_ventana;}
	var w = 0, h = 0;

   	w = screen.width;
   	h = screen.height;

	var leftPos = (w-popW)/2, topPos = (h-popH)/2;

    popupWindow=open(''+ventana+'',nom,'resizable=no,scrollbars=yes,width='+popW+',height='+popH+',top='+topPos+',left='+leftPos);
    if (popupWindow.opener == null){popupWindow.opener = self;}
}
//------------------------------------------------------------------------
function highlight_div(checkbox_node){
    label_node = checkbox_node.parentNode;

    if (checkbox_node.checked){
		label_node.style.backgroundColor='#5B646C';
		label_node.style.color='#ffffff';
	} else {
		label_node.style.backgroundColor='#ffffff';
		label_node.style.color='#000000';
	}
}
//------------------------------------------------------------------------
function emailCheck(emailStr){
	var emailPat = /^(.+)@(.+)$/
	var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
	var validChars = "\[^\\s" + specialChars + "\]"
	var quotedUser = "(\"[^\"]*\")"
	var ipDomainPat= /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
	var atom = validChars + '+'
	var word = "(" + atom + "|" + quotedUser + ")"
	var userPat = new RegExp("^" + word + "(\\." + word + ")*$")
	var domainPat = new RegExp("^" + atom + "(\\." + atom +")*$")
	var matchArray=emailStr.match(emailPat)

	if (matchArray == null){
		alert("El email ingresado parece incorrecto (revise el @ y los puntos)");
		return false;
	}
	var user = matchArray[1]
	var domain = matchArray[2]
	if (user.match(userPat) == null){
	    alert("El nombre de usuario parece no ser válido."); return false;
	}
	var IPArray = domain.match(ipDomainPat)
	if (IPArray!=null){
		for (var i=1;i<=4;i++){
			if (IPArray[i]>255){
				alert("La dirección IP de destino no es válida."); return false;
			}
		}
    	return true;
	}
	var domainArray=domain.match(domainPat)
	if (domainArray==null){
		alert("El nombre de dominio parece no ser válido."); return false;
	}
	var atomPat = new RegExp(atom,"g")
	var domArr = domain.match(atomPat)
	var len = domArr.length
	if (domArr[domArr.length-1].length<2 || domArr[domArr.length-1].length>3){
	   alert("La dirección debe terminar en un dominio de tres letras ó en un país de dos letras."); return false;
	}
	if (len<2){
	   alert("La dirección no tiene el nombre del host."); return false;
	}
	return true;
}
//------------------------------------------------------------------------
function checkAll(caja){
	var qEstado = false;
	var cantidad= caja.length;
	if (document.getElementById('check_todos').checked){
		qEstado = true;
	}
	for (i=0; i<cantidad; i++){caja[i].checked = qEstado;}
}
//------------------------------------------------------------------------
function pos_real(objeto,cual){
	var curleft = curtop = 0;
	if (objeto.offsetParent){
		curleft= objeto.offsetLeft;
		curtop = objeto.offsetTop;
		while (objeto = objeto.offsetParent){
			curleft += objeto.offsetLeft;
			curtop += objeto.offsetTop;
	}}
	if (cual=='x'){return curleft;} else {return curtop;}
}
//------------------------------------------------------------------------
function opacity(id, opacStart, opacEnd, millisec){
	var timer = 0;
    var speed = Math.round(millisec / 100);
    for(i = opacStart; i <= opacEnd; i++){
        setTimeout("changeOpac(" + i + ",'" + id + "')", timer * speed); timer++;
    }
}
function changeOpac(opacity, id){
    var object = document.getElementById(id).style;
    object.opacity = (opacity / 100);
    object.MozOpacity = (opacity / 100);
    object.KhtmlOpacity = (opacity / 100);
    object.filter = "alpha(opacity=" + opacity + ")";
}