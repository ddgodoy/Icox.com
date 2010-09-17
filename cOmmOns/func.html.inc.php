<?php
	function llenarSelect($datos, $seleccionado = ""){
		$Opciones = "";
		foreach($datos as $indice => $valor){
			$elegida = "";
			if ($indice == $seleccionado){$elegida = " SELECTED ";}
			$Opciones .= "<option value='$indice' $elegida>$valor</option>\n";
		}		
		return $Opciones;
	}
//------------------------------------------------------------------------------------
	function llenarSelectMultiple($datos, $seleccionados){
		$Opciones = "";
		if (!is_array($seleccionados)){$seleccionados = array($seleccionados);}
		foreach($datos as $indice => $valor){
			$elegida = "";
			if (in_array($indice, $seleccionados))
				$elegida = " SELECTED ";

			$Opciones .= "<option value='$indice' $elegida>$valor</option>\n";
		}
		return $Opciones;
	}
//	function llenarSelectMultiple($objeto, $datos, $seleccionados = ""){
//		$Opciones = "<div class='d_2'>";
//		if (!is_array($seleccionados)){
//			$seleccionados = array($seleccionados);
//		}
//		foreach($datos as $indice => $valor){
//			$elegida = "";
//			$bgcolor = "#ffffff";
//			$frcolor = "#000000";
//			if (in_array($indice, $seleccionados)){
//				$elegida = " CHECKED ";
//				$bgcolor = "#5B646C";
//				$frcolor = "#ffffff";
//			}
//			$Opciones .= "<label for='cb$indice' style='padding-right:3px;display:block;background-color:$bgcolor;color:$frcolor;'>";
//			$Opciones .= "<input name='$objeto' value='$indice' type='checkbox' id='cb$indice' $elegida onclick='highlight_div(this);'>";
//			$Opciones .= "$valor</label>\n";
//		}
//		return $Opciones."</div>";
//	}
//------------------------------------------------------------------------------------
	function noCache(){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		header("Pragma: no-cache"); 
	}
//------------------------------------------------------------------------------------
	function redireccionar($pagina, $dlink = ""){
		if (empty($dlink)){header("Location: $pagina");} else {echo "<a href='$pagina'>$dlink</a>";} exit();
	}
//------------------------------------------------------------------------------------
	function nombresMes($nro_mes, $idioma = 'es'){
		$nro_mes = is_int($nro_mes) ? $nro_mes: (integer) $nro_mes;
		$nro_mes = $nro_mes > 0 && $nro_mes < 13 ? $nro_mes : 1;

		$arMeses = array('es'=>array(1=>'Enero'  ,'Febrero' ,'Marzo','Abril','Mayo','Junio','Julio'  ,'Agosto','Setiembre','Octubre','Noviembre','Diciembre'),
					     'en'=>array(1=>'January','February','March','April','May' ,'June' ,'July'   ,'August','September','October','November' ,'December'),
						 'fr'=>array(1=>'Janvier','Février' ,'Mars' ,'Avril','Mai' ,'Juin' ,'Juillet','Août'  ,'Septembre','Octobre','Novembre' ,'Décembre'),
						 'de'=>array(1=>'Januar' ,'Februar' ,'März' ,'April','Mai' ,'Juni' ,'Juli'   ,'August','September','Oktober','November' ,'Dezember'));
		return $arMeses[$idioma][$nro_mes];
	}
//------------------------------------------------------------------------------------
	function diaSemana($nro_dia, $idioma = 'es'){
		$nro_dia = is_int($nro_dia) ? $nro_dia : (integer) $nro_dia;
		$nro_dia = $nro_dia >= 0 && $nro_dia <= 6 ? $nro_dia : 0;

		$arrDias = array('es'=>array('Domingo' ,'Lunes' ,'Martes'  ,'Miércoles','Jueves'    ,'Viernes' ,'Sábado'),
					     'en'=>array('Sunday'  ,'Monday','Tuesday' ,'Wednesday','Thursday'  ,'Friday'  ,'Saturday'),
					     'fr'=>array('Dimanche','Lundi' ,'Mardi'   ,'Mercredi' ,'Jeudi'     ,'Vendredi','Samedi'),
					     'de'=>array('Sonntag' ,'Montag','Dienstag','Mittwoch' ,'Donnerstag','Freitag' ,'Samstag'));
		return $arrDias[$idioma][$nro_dia];
	}
//------------------------------------------------------------------------------------
	function numDiaSemana($mes, $anio){
		$numDiaSemana = date('w', mktime(0, 0, 0, $mes, 1, $anio));
		$numDiaSemana = $numDiaSemana == 0 ? 6 : $numDiaSemana - 1;

		return $numDiaSemana;
	}
//------------------------------------------------------------------------------------
	function ultimoDiaMes($mes, $anio){
    	$ultimoDia = 28; 
    	while (checkdate($mes, $ultimoDia + 1, $anio)){
    		$ultimoDia++;
    	}
    	return $ultimoDia; 
	}
?>