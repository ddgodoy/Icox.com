<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';
	require_once getLocal('CLI').'class.clientes.inc.php';
	
	$oMyDB = new clsMyDB();
	/*----------------------------------------------------------------------*/
	$queHacer = isset($_GET['qhacer'])?'CHECKED':'';
	/*----------------------------------------------------------------------*/
	$rLast = $oMyDB->Query("SELECT MAX(cliOrden) as ultimo FROM clientes;");
	if ($rLast){
		$dLast = mysql_fetch_assoc($rLast);
		$stORDEN = $dLast['ultimo'] + 1;
	} else {
		$stORDEN = 0;
	}
	$stNOMBRE= '';
	$stERROR = '';

	if (isset($_POST['btn_accion'])){
		$stORDEN  = $_POST['orden'];
		$stNOMBRE = $_POST['nombre'];

		$oCliente = new clsClientes();
		$oCliente->clearErrores();
		
		$oCliente->setOrden ($stORDEN);
		$oCliente->setNombre($stNOMBRE);

		if (!$oCliente->hasErrores() && $oCliente->Registrar()){
			if (isset($_POST['qhacer'])){
				redireccionar(getWeb('CLI').'cli.registrar.php?qhacer=1');
			}
			redireccionar(getWeb('CLI').'cli.listar.php');
		}
		$stERROR = $oCliente->getErrores();
	}
	$oSmarty->assign('stERROR' , $stERROR);
	$oSmarty->assign('stNOMBRE', $stNOMBRE);
	$oSmarty->assign('stORDEN' , $stORDEN);
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stQUEHACER', $queHacer);
	$oSmarty->assign('stVEROPC'  , 1);
/*----------------------------------------------------------------------*/
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Nuevo cliente');
	$oSmarty->assign('stBTN_ACTION', 'Nuevo');

	$oSmarty->display('cli.registrar.tpl.html');
?>