<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB = new clsMyDB();
//-----------------------------------------------------------------------------------
	$aOrder = array('dominio'=>'dmi.dominio', 'usuario'=>'usu.apellido');
	$stORD  = 'dominio';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stUSER = '';
	$stFILT = '';

//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}

//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND dmi.dominio LIKE '%$stTEXT%' ";
	}
	if(!empty($_REQUEST['usuario'])){
		$stUSER = $_REQUEST['usuario'];
		$stFILT.= " AND dmi.usuario_id = $stUSER ";
	}

	$QUERY = "SELECT dmi.id AS dmi_id, dmi.dominio AS dmi_dominio, usu.apellido AS usu_apellido, usu.nombre AS usu_nombre FROM ".
					 "dominio dmi LEFT JOIN usuario usu ON dmi.usuario_id = usu.id WHERE dmi.id > 0 $stFILT ORDER BY $aOrder[$stORD] $stSNT";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;

// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0) {
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay dominios registrados.';
			$stARRAY = array('desc'=>'Nuevo dominio', 'link'=>'registrar.php');
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de dominios');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['dmi_id'];
		$Ur = $fila['usu_apellido'] ? $oMyDB->forShow($fila['usu_apellido'].', '.$fila['usu_nombre']) : '-';
		
		$aDominios[$Id]['dominio'] = $oMyDB->forShow($fila['dmi_dominio']);
		$aDominios[$Id]['usuario'] = $Ur;
	}
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stDOMINIOS', $aDominios);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stUSER', $stUSER);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de dominios');
	
	$oSmarty->display('dmi.listar.tpl.html');
?>