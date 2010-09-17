<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB = new clsMyDB();
	$Count = $oMyDB->Query("SELECT COUNT(*) as cant FROM administradores;");
	list($RegTotal) = mysql_fetch_row($Count);

	if ($RegTotal == 0){
		$oSmarty->assign ('stTITLE', 'Listado de administradores');
		$oSmarty->assign ('stLINKS', array(array('desc'=>'Nuevo administrador','link'=>'adm.registrar.php')));
		$oSmarty->assign ('stMESSAGE', 'No hay administradores.');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$PAGE = (isset($_GET['page']))?(integer) $_GET['page']:1;
	$oPaginado = new clsPaginadoSimple($PAGE, $RegTotal, 20);
	$oPaginado->doPaginar();

	$qrySelect = "SELECT * FROM administradores LIMIT {$oPaginado->regStart}, {$oPaginado->regToShow};";
	$resSelect = $oMyDB->Query($qrySelect);

	while ($resSelect && $fila = mysql_fetch_assoc($resSelect)){
		$Id = $fila['admId'];
		$Administradores[$Id]['Login']  = $oMyDB->forShow($fila['admLogin']);
		$Administradores[$Id]['Nombre'] = $oMyDB->forShow($fila['admApellido'].', '.$fila['admNombre']);
		$Administradores[$Id]['Enabled']= ($fila['admEnabled']=='S')?'Habilitado':'Inhabilitado';
		$Administradores[$Id]['Email']  = $oMyDB->forShow($fila['admEmail']);
	}
	$oSmarty->assign_by_ref('stADMINISTRADORES', $Administradores);

	$oSmarty->assign('stREG_TOTAL', $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de administradores');
	
	$oSmarty->display('adm.listar.tpl.html');
?>