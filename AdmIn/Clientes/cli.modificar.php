<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('CLI').'class.clientes.inc.php';

	$stID = 0;
	$stNOMBRE = '';
	$stERROR  = '';

	if (isset($_POST['btn_accion'])){
		$stID = $_POST['id'];
		$stORDEN  = $_POST['orden'];
		$stNOMBRE = $_POST['nombre'];

		$oCliente = new clsClientes();
		$oCliente->clearErrores();

		if ($oCliente->findId($stID)){
			$oCliente->setOrden ($stORDEN);
			$oCliente->setNombre($stNOMBRE);

			if (!$oCliente->hasErrores() && $oCliente->Modificar()){
				redireccionar(getWeb('CLI').'cli.listar.php');
			}
		}
		$stERROR = $oCliente->getErrores();
	}
	elseif (isset($_GET['Id'])){
		$stID = $_GET['Id'];

		$oCliente = new clsClientes();
		$oCliente->clearErrores();

		if (!$oCliente->findId($stID)){
			$oSmarty->assign ('stTITLE', 'Modificar cliente');
			$oSmarty->assign ('stMESSAGE', $oCliente->getErrores());
			$oSmarty->display('information.tpl.html');
			exit();
		}
		$stORDEN  = $oCliente->getOrden();
		$stNOMBRE = $oCliente->editNombre();
	} else {
		$oSmarty->assign ('stTITLE'  , 'Modificar cliente');
		$oSmarty->assign ('stMESSAGE', 'No puede entrar a esta página directamente');
		$oSmarty->display('information.tpl.html');
		exit();
	}
	$oSmarty->assign('stID', $stID);
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stORDEN' , $stORDEN);
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stVEROPC', 0);
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Modificar cliente');
	$oSmarty->assign('stBTN_ACTION', 'Modificar');

	$oSmarty->display('cli.registrar.tpl.html');
?>