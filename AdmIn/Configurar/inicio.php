<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	$oMyDB = new clsMyDB();	
	$rCuenta = $oMyDB->Query("SELECT * FROM configurar;");

	$stEMAIL = '';
	$stACTUALIZADO = '-';
	$stERROR = '';
	//
	if ($rCuenta) {
		$dCuenta = mysql_fetch_assoc($rCuenta);
		$stEMAIL = $oMyDB->forEdit($dCuenta['email']);
		$stACTUALIZADO = $oMyDB->convertDate($dCuenta['actualizado']);
	}
	//
	if (isset($_POST['btn_accion'])) {
		$stEMAIL = trim($_POST['email']);
		
		if (!empty($stEMAIL)) {
			$axEMAIL = $oMyDB->forSave($stEMAIL);
			$axUpd = date('Y-m-d H:i:s');

			$oMyDB->Command("UPDATE configurar SET email = '$axEMAIL', actualizado = '$axUpd';");
			
			redireccionar(getWeb('ADMIN').'contenido.php');
		} else {
			$stERROR = 'Ingrese la cuenta de mail';
		}
	}
	$oSmarty->assign('stERROR', $stERROR);
	$oSmarty->assign('stEMAIL', $stEMAIL);
	$oSmarty->assign('stACTUALIZADO', $stACTUALIZADO);

	$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
	$oSmarty->assign('stTITLE' , 'Configurar cuenta');

	$oSmarty->display('adm.configurar.tpl.html');
?>