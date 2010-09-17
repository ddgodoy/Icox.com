<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CAT').'class.categorias.inc.php';

	$stID = 0;
	$stNOMBRE = '';
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stID = $_POST['id'];
		$stORDEN  = $_POST['orden'];
		$stNOMBRE = $_POST['nombre'];

		$oCategoria = new clsCategorias();
		$oCategoria->clearErrores();

		if ($oCategoria->findId($stID)){
			$oCategoria->setOrden ($stORDEN);
			$oCategoria->setNombre($stNOMBRE);

			if (!$oCategoria->hasErrores() && $oCategoria->Modificar()){
				redireccionar(getWeb('CAT').'cat.listar.php');
			}
		}
		$stERROR = $oCategoria->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oCategoria = new clsCategorias();
		$oCategoria->clearErrores();

		if (!$oCategoria->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Modificar categoría');
			$oSmarty->assign ('stMESSAGE', $oCategoria->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stORDEN  = $oCategoria->getOrden();
		$stNOMBRE = $oCategoria->editNombre();
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar categoría');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stORDEN' , $stORDEN);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar categoría');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');

	$oSmarty->display('cat.registrar.tpl.html');
?>