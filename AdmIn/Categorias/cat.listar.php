<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB = new clsMyDB();
//-----------------------------------------------------------------------------------
	$ban1 = false;
	$res1 = $oMyDB->Query("SELECT catOrden FROM categorias ORDER BY catOrden;");
	while ($res1 && $dat1 = mysql_fetch_assoc($res1)){
		$ord1 = $dat1['catOrden'];
		$res2 = $oMyDB->Query("SELECT COUNT(catId) as cuantos FROM categorias WHERE catOrden = $ord1;");
		$dat2 = mysql_fetch_assoc($res2);

		if ($dat2['cuantos'] > 1){$ban1 = true; break;}
	}
	if ($ban1){
		$ord2 = 0; $res3 = $oMyDB->Query("SELECT catId FROM categorias ORDER BY catOrden;");
		while ($res3 && $dat3 = mysql_fetch_assoc($res3)){
			$ord2++; $cod1 = $dat3['catId'];
			$oMyDB->Command("UPDATE categorias SET catOrden = $ord2 WHERE catId = $cod1;");
		}
	}
//-----------------------------------------------------------------------------------
	$aOrder = array('orden'=>'catOrden', 'nombre'=>'catNombre');
	$stORD  = 'orden';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stFILT = '';
//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}
//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND catNombre LIKE '%$stTEXT%' ";
	}
	$QUERY = "SELECT * FROM categorias WHERE catId > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;
// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay categorias registradas.';
			$stARRAY = array('desc'=>'Nueva categoria', 'link'=>'cat.registrar.php');
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'cat.listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de categorías');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['catId'];
		$aCategorias[$Id]['Orden'] = $fila['catOrden'];
		$aCategorias[$Id]['Nombre'] = $oMyDB->forShow($fila['catNombre']);
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stCATEGORIAS', $aCategorias);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de categorías');
	
	$oSmarty->display('cat.listar.tpl.html');
?>