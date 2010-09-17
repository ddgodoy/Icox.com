<?php
	$destino = '';
	$mensaje = '<p><b>';
	
	if (isset($_POST['enviar'])){
		$desde = $_SERVER['HTTP_HOST'];

		if (strpos($desde, 'w')  !== false){
			$desde = substr($desde, 4);
		}
		$destino= $_POST['destino'];
		$fecha  = date('d/m/Y H:i:s');
		$headers= 'From: test@'.$desde . "\r\n" .
					    'Reply-To: ovr@icox.mobi' . "\r\n" .
					    'Return-Path: ovr@icox.mobi' . "\r\n".
		   			  'X-Mailer: PHP/' . phpversion();

		if (mail($destino, "Prueba - $fecha", "Enviado desde: $desde", $headers)){
			$mensaje .= 'La funci&oacute;n mail se ejecut&oacute; correctamente<br />'.
								  '(verifique que el servidor haya resuelto el env&iacute;o)';
		} else {
			$mensaje .= 'La funci&oacute;n mail NO se ejecut&oacute; correctamente';
		}
	}
	$mensaje .= '</p></b>';
?>
<html>
	<head>
		<title>Prueba mail</title>
		<script language="javascript" type="text/javascript">
			function checkForm(){
				var destino = document.getElementById('destino');
				if (destino.value == ''){
					alert('Complete el email de destino'); destino.focus(); return false;
				}
				return true;
			}
		</script>
	</head>
	<body style="font-family:arial;font-size:12px;">
		<center>
			<br /><br /><?php echo $mensaje; ?>
			<form method="POST" enctype="multipart/form-data" action="_test_mail.php">
			<table>
				<tr><td>Email destino</td></tr>
				<tr>
					<td>
						<input name="destino" id="destino" type="text" size="35" value="<?php echo $destino; ?>"/>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr><td><input type="submit" value="Enviar" name="enviar" onclick="return checkForm();"/></td></tr>
				</tr>
			</table>
			</form>
		</center>
	</body>
</html>