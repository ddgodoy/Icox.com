<?php
	require_once 'cOmmOns/config.inc.php';

	$stACCION_ONLOAD = 'onload="oImg_8.start();"';

	$oSmarty->assign('stACCION_ONLOAD', $stACCION_ONLOAD);
	$oSmarty->display('tpl.privacy_policy'.$_SESSION['_front_idioma'].'.html');
?>