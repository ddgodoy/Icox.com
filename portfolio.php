<?php
	require_once 'cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	$oMyDB = new clsMyDB();
	/*--------------------------------------------------------------------------------------*/
	$labelSelect = $_SESSION['_front_idioma'] == '_es'?'seleccionar':'select';
	
	$aInd = array(0 => "---  $labelSelect  ---");
	$rInd = $oMyDB->Query("SELECT * FROM industrias ORDER BY indNombre;");

	while ($rInd && $fInd = mysql_fetch_assoc($rInd)){
		$aInd[$fInd['indId']] = $oMyDB->forShow($fInd['indNombre']);
	}
	$aCat = array(0 => "---  $labelSelect  ---");
	$rCat = $oMyDB->Query("SELECT * FROM categorias ORDER BY catNombre;");

	while ($rCat && $fCat = mysql_fetch_assoc($rCat)){
		$aCat[$fCat['catId']] = $oMyDB->forShow($fCat['catNombre']);
	}
	$aSub = array(0 => "---  $labelSelect  ---");
	$rSub = $oMyDB->Query("SELECT * FROM subcategorias ORDER BY subNombre;");

	while ($rSub && $fSub = mysql_fetch_assoc($rSub)){
		$aSub[$fSub['subId']] = $oMyDB->forShow($fSub['subNombre']);
	}
	/*--------------------------------------------------------------------------------------*/
	$selIND = 0;
	$selCAT = 0;
	$selSUB = 0;
	$stFILTER = '';
	$stTABLAS = "proyectos pro,";

	if(!empty($_REQUEST['industria'])){
		$selIND = $_REQUEST['industria'];
		$stFILTER .= " AND pro.proId = ind.proyecto AND ind.industria = $selIND";
		$stTABLAS .= " proyectos_industrias ind,";
	}
	if(!empty($_REQUEST['categoria'])){
		$selCAT = $_REQUEST['categoria'];
		$stFILTER .= " AND pro.proId = cat.proyecto AND cat.categoria = $selCAT";
		$stTABLAS .= " proyectos_categorias cat,";
	}
	if(!empty($_REQUEST['subcategoria'])){
		$selSUB = $_REQUEST['subcategoria'];
		$stFILTER .= " AND pro.proId = sub.proyecto AND sub.subcategoria = $selSUB";
		$stTABLAS .= " proyectos_subcategorias sub,";
	}
	$stTABLAS = substr($stTABLAS, 0, -1);

	$QUERY = "SELECT pro.proId as id, pro.proNombre as nombre, pro.proCliente as cliente, pro.proObjetivo as ".
			 "objetivo, pro.proSituacion as situacion, pro.proPropuesta as propuesta, pro.proResultados as ".
			 "resultados, pro.proImagen as logo FROM $stTABLAS WHERE pro.proId > 0 $stFILTER ORDER BY pro.proOrden";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;

	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 6);
	$oPaginado->doPaginar();	

	if ($oPaginado->getCantidadRegistros() > 0){
		/*-----------------------------------------------------------------------------------*/
		function TieneMasDatos($datos){
			if (!empty($datos['cliente']))   {return true;}
			if (!empty($datos['objetivo']))  {return true;}
			if (!empty($datos['situacion'])) {return true;}
			if (!empty($datos['propuesta'])) {return true;}
			if (!empty($datos['resultados'])){return true;}

			return false;
		}
		function TieneGaleria($id, $db){
			if($db->Query("SELECT imgId FROM proyectos_imagenes WHERE imgProyecto = $id LIMIT 1;")){
				return true;
			} else {return false;}
		}
		/*-----------------------------------------------------------------------------------*/
		$stRUTA = getWeb('FPR');
		$result = &$oPaginado->registros;

		$arProyectos = array();
		while ($result && $fila = mysql_fetch_assoc($result)){
			$Id = $fila['id'];
			$arProyectos[$Id]['VerMas'] = false;
			$arProyectos[$Id]['Nombre'] = $oMyDB->forShow($fila['nombre']);
			$arProyectos[$Id]['Cliente']= $oMyDB->forShow($fila['cliente']);
	 		$arProyectos[$Id]['Imagen'] = $fila['logo'] ? $stRUTA.$fila['logo'] : '';

	 		if (TieneMasDatos($fila) || TieneGaleria($Id, $oMyDB)){
	 			$arProyectos[$Id]['VerMas'] = true;
	 		}
		}
		$oSmarty->assign('stPROYECTOS', $arProyectos);
		$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
		$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	}
	$oSmarty->assign('stINDUSTRIA', llenarSelect($aInd, $selIND));
	$oSmarty->assign('stCATEGORIA', llenarSelect($aCat, $selCAT));
	$oSmarty->assign('stSUBCATEGORIA', llenarSelect($aSub, $selSUB));

	$oSmarty->display('tpl.portfolio'.$_SESSION['_front_idioma'].'.html');
?>