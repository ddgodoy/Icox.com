<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('CAT').'class.categorias.inc.php';

	$oMyDB = new clsMyDB();
	/*----------------------------------------------------------------------*/
	$rLast = $oMyDB->Query("SELECT MAX(catOrden) as ultimo FROM categorias;");
	if ($rLast){
		$dLast = mysql_fetch_assoc($rLast);
		$stORDEN = $dLast['ultimo'] + 1;
	} else {
		$stORDEN = 0;
	}
	/*----------------------------------------------------------------------*/
	$stNOMBRE = '';
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stORDEN  = $_POST['orden'];
		$stNOMBRE = $_POST['nombre'];

		$oCategoria = new clsCategorias();
		$oCategoria->clearErrores();
		
		$oCategoria->setOrden ($stORDEN);
		$oCategoria->setNombre($stNOMBRE);

		if (!$oCategoria->hasErrores() && $oCategoria->Registrar()){
			redireccionar(getWeb('CAT').'cat.listar.php');
		}
		$stERROR = $oCategoria->getErrores();
	}
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stORDEN' , $stORDEN);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nueva categoría');
	$oSmarty->assign('stBTN_ACTION', 'Nueva');

	$oSmarty->display('cat.registrar.tpl.html');
?>