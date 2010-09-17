<?php
	include_once '../cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	if (isset($_SESSION['_clienteId'])){redireccionar(getWeb('CLIENTE').'contenido.php');}
	$_SESSION['_clienteNombre'] = 'No hay un usuario registrado todavia.';

	$stERROR = '';
	$stEMAIL = '';

	if (isset($_POST['btnLogin'])){
		$stEMAIL = $_POST['email'];
		$stPASSW = $_POST['password'];

		require_once getLocal('USU').'class.usuarios.inc.php';

		$oUsuario = new clsUsuarios();
		$oUsuario->clearErrores();

		$oUsuario->doLogin($stEMAIL, $stPASSW);

		if (!$oUsuario->hasErrores()){
			$_SESSION['_clienteId'] = $oUsuario->id;
			$_SESSION['_clienteNombre'] = $oUsuario->apellido.', '.$oUsuario->nombre;
			$_SESSION['_clienteAdminEmail'] = $oUsuario->getCuentaAdministrador();

			redireccionar(getWeb('CLIENTE').'contenido.php');
		}
		$stERROR = $oUsuario->getErrores();
	}
	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stEMAIL' , $stEMAIL);
	$oSmarty->assign('stERROR' , $stERROR);

	$oSmarty->display('cliente.login.tpl.html');
?>