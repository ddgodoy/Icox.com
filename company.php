<?php
	require_once 'cOmmOns/config.inc.php';
	
	$stACCION_ONLOAD = 'onload="oImg_1.start();"';
	
	$oSmarty->assign('stACCION_ONLOAD', $stACCION_ONLOAD);
	$oSmarty->display('tpl.company'.$_SESSION['_front_idioma'].'.html');
?>