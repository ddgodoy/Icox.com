<?php
	require_once 'cOmmOns/config.inc.php';

	$stACCION_ONLOAD = 'onload="oImg_4.start();"';
	
	$oSmarty->assign('stACCION_ONLOAD', $stACCION_ONLOAD);
	$oSmarty->display('tpl.offices'.$_SESSION['_front_idioma'].'.html');
?>