<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('SUB').'class.subcategorias.inc.php';

	$oMyDB = new clsMyDB();
	/*----------------------------------------------------------------------*/
	$aCat = array('-- seleccionar --');
	$rCat = $oMyDB->Query("SELECT * FROM categorias ORDER BY catOrden;");
	while ($rCat && $fCat = mysql_fetch_assoc($rCat)){
		$aCat[$fCat['catId']] = $oMyDB->forShow($fCat['catNombre']);
	}
	/*----------------------------------------------------------------------*/
	$stNOMBRE = '';
	$stCATEGORIA = llenarSelect($aCat);
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stCATEGORIA = $_POST['categoria'];
		$stNOMBRE = $_POST['nombre'];

		$oSubcategoria = new clsSubcategorias();
		$oSubcategoria->clearErrores();
		
		$oSubcategoria->setCategoria($stCATEGORIA);
		$oSubcategoria->setNombre($stNOMBRE);

		if (!$oSubcategoria->hasErrores() && $oSubcategoria->Registrar()){
			redireccionar(getWeb('SUB').'sub.listar.php');
		}
		$stCATEGORIA = llenarSelect($aCat);
		$stERROR = $oSubcategoria->getErrores();
	}
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stCATEGORIA', $stCATEGORIA);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nueva subcategoría');
	$oSmarty->assign('stBTN_ACTION', 'Nueva');

	$oSmarty->display('sub.registrar.tpl.html');
?>