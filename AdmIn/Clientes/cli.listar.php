<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB = new clsMyDB();
//-----------------------------------------------------------------------------------
	$ban1 = false;
	$res1 = $oMyDB->Query("SELECT cliOrden FROM clientes ORDER BY cliOrden;");
	while ($res1 && $dat1 = mysql_fetch_assoc($res1)){
		$ord1 = $dat1['cliOrden'];
		$res2 = $oMyDB->Query("SELECT COUNT(cliId) as cuantos FROM clientes WHERE cliOrden = $ord1;");
		$dat2 = mysql_fetch_assoc($res2);

		if ($dat2['cuantos'] > 1){$ban1 = true; break;}
	}
	if ($ban1){
		$ord2 = 0; $res3 = $oMyDB->Query("SELECT cliId FROM clientes ORDER BY cliOrden;");
		while ($res3 && $dat3 = mysql_fetch_assoc($res3)){
			$ord2++; $cod1 = $dat3['cliId'];
			$oMyDB->Command("UPDATE clientes SET cliOrden = $ord2 WHERE cliId = $cod1;");
		}
	}
//-----------------------------------------------------------------------------------
	$aOrder = array('orden'=>'cliOrden', 'nombre'=>'cliNombre');
	$stORD  = 'orden';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stFILT = '';
//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}
//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND cliNombre LIKE '%$stTEXT%' ";
	}
	$QUERY = "SELECT * FROM clientes WHERE cliId > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;
// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay clientes registrados.';
			$stARRAY = array('desc'=>'Nuevo cliente', 'link'=>'cli.registrar.php');
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'cli.listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de clientes');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['cliId'];
		$aClientes[$Id]['Orden'] = $fila['cliOrden'];
		$aClientes[$Id]['Nombre'] = $oMyDB->forShow($fila['cliNombre']);
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stCLIENTES', $aClientes);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de clientes');
	
	$oSmarty->display('cli.listar.tpl.html');
?>