<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB = new clsMyDB();
//-----------------------------------------------------------------------------------
	$ban1 = false;
	$res1 = $oMyDB->Query("SELECT proOrden FROM proyectos ORDER BY proOrden;");
	while ($res1 && $dat1 = mysql_fetch_assoc($res1)){
		$ord1 = $dat1['proOrden'];
		$res2 = $oMyDB->Query("SELECT COUNT(proId) as cuantos FROM proyectos WHERE proOrden = $ord1;");
		$dat2 = mysql_fetch_assoc($res2);

		if ($dat2['cuantos'] > 1){$ban1 = true; break;}
	}
	if ($ban1){
		$ord2 = 0; $res3 = $oMyDB->Query("SELECT proId FROM proyectos ORDER BY proOrden;");
		while ($res3 && $dat3 = mysql_fetch_assoc($res3)){
			$ord2++; $cod1 = $dat3['proId'];
			$oMyDB->Command("UPDATE proyectos SET proOrden = $ord2 WHERE proId = $cod1;");
		}
	}
//-----------------------------------------------------------------------------------
	$aOrder = array('orden'=>'proOrden', 'nombre'=>'proNombre', 'referencia'=>'proReferencia');
	$stORD  = 'orden';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stFILT = '';
//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}
//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND proNombre LIKE '%$stTEXT%' ";
	}
	$QUERY = "SELECT proId, proOrden, proNombre, proReferencia FROM proyectos WHERE proId > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;
// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay proyectos registrados.';
			$stARRAY = array('desc'=>'Nuevo proyecto', 'link'=>'pro.registrar.php');
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'pro.listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de proyectos');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['proId'];
		$aProyectos[$Id]['Orden'] = $fila['proOrden'];
		$aProyectos[$Id]['Nombre'] = $oMyDB->forShow($fila['proNombre']);
		$aProyectos[$Id]['Referencia'] = $oMyDB->forShow($fila['proReferencia']);
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stVALORES', $aProyectos);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de proyectos');

	$oSmarty->display('pro.listar.tpl.html');
?>