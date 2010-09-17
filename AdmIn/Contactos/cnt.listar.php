<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB  = new clsMyDB();
	$aOrder = array('fecha'=>'cntFecha', 'nombre'=>'cntNombre', 'email'=>'cntEmail');
	$stORD  = 'fecha';
	$stSNT  = 'DESC';
	$stTEXT = '';
	$stFILT = '';
//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}
//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND cntNombre LIKE '%$stTEXT%' ";
	}
	$QUERY = "SELECT * FROM contactos WHERE cntId > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;
// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		$oSmarty->assign ('stTITLE', 'Listado de contactos');
		$oSmarty->assign ('stMESSAGE', 'No hay contactos registrados.');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['cntId'];
		$aContactos[$Id]['Fecha'] = $oMyDB->convertDate($fila['cntFecha']);
		$aContactos[$Id]['Nombre']= $oMyDB->forShow($fila['cntNombre']);
		$aContactos[$Id]['Email'] = $oMyDB->forShow($fila['cntEmail']);
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stCONTACTOS', $aContactos);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de contactos');

	$oSmarty->display('cnt.listar.tpl.html');
?>