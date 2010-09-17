<?php
	require_once 'cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	$oMyDB = new clsMyDB();
	$axCli = $oMyDB->Query("SELECT COUNT(*) as cnt FROM clientes;");
	$dxCli = mysql_fetch_assoc($axCli);	

	$arCOLUMNA1 = array();
	$arCOLUMNA2 = array();
	
	if ($dxCli['cnt'] > 0){
		$countr = 0;
		$xCant1 = ceil($dxCli['cnt'] / 2);
		
		$rsCli = $oMyDB->Query("SELECT * FROM clientes ORDER BY cliOrden;");
		while ($fila = mysql_fetch_assoc($rsCli)){
			$countr++;
			if ($countr > $xCant1){
				$arCOLUMNA2[] = $oMyDB->forShow($fila['cliNombre']);
			} else {
				$arCOLUMNA1[] = $oMyDB->forShow($fila['cliNombre']);
			}
		}
	}
	$oSmarty->assign('stCOLUMNA1', $arCOLUMNA1);
	$oSmarty->assign('stCOLUMNA2', $arCOLUMNA2);

	$oSmarty->display('tpl.clients'.$_SESSION['_front_idioma'].'.html');
?>