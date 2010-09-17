<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB  = new clsMyDB();
	$aOrder = array('nombre'=>'indNombre');
	$stORD  = 'nombre';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stFILT = '';
//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}
//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND indNombre LIKE '%$stTEXT%' ";
	}
	$QUERY = "SELECT * FROM industrias WHERE indId > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;
// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay industrias registradas.';
			$stARRAY = array('desc'=>'Nueva industria', 'link'=>'ind.registrar.php');
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'ind.listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de industrias');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['indId'];
		$aIndustrias[$Id]['Nombre'] = $oMyDB->forShow($fila['indNombre']);
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stINDUSTRIAS', $aIndustrias);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de industrias');
	
	$oSmarty->display('ind.listar.tpl.html');
?>