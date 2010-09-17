<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';
	require_once getLocal('IMG').'class.imagenes.inc.php';

	$oImagenes = new clsImagenes();

	if (!empty($_REQUEST['codigo'])){
		$stCODIGO = $_REQUEST['codigo'];
		$stTITULO = $oImagenes->getTitulo($stCODIGO);
	} else {
		$oSmarty->assign ('stTITLE'  , 'Galería de im&aacute;genes');
		$oSmarty->assign ('stMESSAGE', 'No puede ingresar a esta p&aacute;gina directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oMyDB = new clsMyDB();
	$QUERY = "SELECT * FROM proyectos_imagenes WHERE imgProyecto = $stCODIGO ORDER BY imgCarga";
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;

	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE, 9);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		$oSmarty->assign ('stTITLE', 'Listado de im&aacute;genes');
		$oSmarty->assign ('stLINKS', array(array('desc'=>'Nueva imagen','link'=>"img.registrar.php?codigo=$stCODIGO")));
		$oSmarty->assign ('stMESSAGE', "No hay im&aacute;genes para $stTITULO");
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;

	$i=0;
	$j=0;
	$stRUTA = getWeb('FPR');
	$stIMAGENES = array();

	while ($result && $fila = mysql_fetch_assoc($result)){
		$stIMAGENES[$i][$j]['Id'] = $fila['imgId'];
 		$stIMAGENES[$i][$j]['Imagen'] = $stRUTA.'c'.$fila['imgImagen'];

 		if ($j == 2){$i++;$j = 0;} else {$j++;}
	}
	$oSmarty->assign_by_ref('stIMAGENES', $stIMAGENES);
	$oSmarty->assign('stCODIGO', $stCODIGO);
	$oSmarty->assign('stTITULO', $stTITULO);

	$oSmarty->assign('stREG_TOTAL', $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de im&aacute;genes');

	$oSmarty->display('img.listar.tpl.html');
?>