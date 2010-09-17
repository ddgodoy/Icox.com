<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('CLIENTE').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB = new clsMyDB();
//-----------------------------------------------------------------------------------
	$aOrder = array('dominio'=>'dominio', 'creado'=>'creado', 'actualizado'=>'actualizado');
	$stORD  = 'dominio';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stFILT = " AND usuario_id = ".$_SESSION['_clienteId'];

//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}

//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND dominio LIKE '%$stTEXT%'";
	}

	$QUERY = "SELECT * FROM dominio WHERE id > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;

// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0) {
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay dominios registrados.';
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'cliente.listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de dominios');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('cliente.information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;

// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['id'];

		$aDominios[$Id]['dominio'] = $oMyDB->forShow($fila['dominio']);
		$aDominios[$Id]['creado'] = $oMyDB->convertDate($fila['creado']);
		$aDominios[$Id]['actualizado'] = $oMyDB->convertDate($fila['actualizado']);
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stDOMINIOS', $aDominios);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de dominios');
	
	$oSmarty->display('cliente.listar.tpl.html');
?>