<?php
	require_once getLocal('ADMIN').'sesion_admin.inc.php';

	$contenido[] = array('Desc'=>'Sistema','Link'=>'');

	if ($_SESSION['_admRoot']) {
		$contenido[] = array('Desc'=>'Usuarios'  , 'Link'=>getWeb('USU').'listar.php');
		$contenido[] = array('Desc'=>'Dominios'  , 'Link'=>getWeb('DMI').'listar.php');
		$contenido[] = array('Desc'=>'Configurar', 'Link'=>getWeb('CNF').'inicio.php');
	}
	$contenido[] = array('Desc'=>'Mis datos' ,'Link'=>getWeb('ADM').'adm.modificar.php?ban=1&amp;Id='.$_SESSION['_admId']);
	$contenido[] = array('Desc'=>'-'         , 'Link'=>'');
	$contenido[] = array('Desc'=>'Portfolio' ,'Link'=>'');
	$contenido[] = array('Desc'=>'Clientes'  ,'Link'=>getWeb('CLI').'cli.listar.php');
	$contenido[] = array('Desc'=>'Proyectos' ,'Link'=>getWeb('PRO').'pro.listar.php');
	$contenido[] = array('Desc'=>'Categorias','Link'=>getWeb('CAT').'cat.listar.php');
	$contenido[] = array('Desc'=>'Subcategorias','Link'=>getWeb('SUB').'sub.listar.php');
	$contenido[] = array('Desc'=>'Industrias','Link'=>getWeb('IND').'ind.listar.php');
	$contenido[] = array('Desc'=>'-'         , 'Link'=>'');
	$contenido[] = array('Desc'=>'Contactos' ,'Link'=>'');
	$contenido[] = array('Desc'=>'Listado'   ,'Link'=>getWeb('CNT').'cnt.listar.php');

	$oSmarty->assign('stADMIN_ID' , $_SESSION['_admId']);
	$oSmarty->assign('stROOT_FLAG', $_SESSION['_admRoot']);
	$oSmarty->assign('stCONTENIDO', $contenido);
?>