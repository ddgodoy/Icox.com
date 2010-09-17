<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsAdministrador{
		var $Id = 0;
		var $Nombre  = '';
		var $Apellido= '';
		var $Enabled = '';
		var $Login   = '';
		var $Fecnac  = '';
		var $Email   = '';
		var $Password= '';
		var $Confirma= '';
		var $Root    = 0;
		var $Errores = array();
		var $DB;

		function clsAdministrador(){
			$this->clearAdministrador();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearAdministrador(){
			$this->Id = 0;
			$this->Nombre  = '';
			$this->Apellido= '';
			$this->Enabled = '';
			$this->Login   = '';
			$this->Fecnac  = '';
			$this->Email   = '';
			$this->Password= '';
			$this->Confirma= '';
			$this->Root    = 0;
			$this->Errores = array();
		}
		function Validar(){
			if ($this->Id == 0){
				if ($this->Confirma != $this->Password){$this->Errores['Confirmacion'] = 'La contrase�a no coincide con su confirmaci�n.';}
			}
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if ($this->DB->Query("SELECT admId FROM administradores WHERE admLogin = '$this->Login';")){
				$this->Errores['Login'] = 'El administrador ya existe.';
			}
			if (!$this->Validar()){return FALSE;}

			$qInsert = "INSERT INTO administradores (admNombre, admApellido, admLogin, admPassword, admEnabled, admEmail, ".
					   		 "admFecnac, admRoot) VALUES ('$this->Nombre', '$this->Apellido', '$this->Login', password('$this->Password')".
					   		 ", '$this->Enabled', '$this->Email', '$this->Fecnac', $this->Root);";
			$rInsert = $this->DB->Command($qInsert);

			if (!$rInsert){
				$this->Errores['Registrar'] = 'El administrador no puede ser registrado.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			return TRUE;
		}
		function Modificar(){
			if (!$this->DB->Query("SELECT admId FROM administradores WHERE admId = $this->Id;")){
				$this->Errores['Modificar'] = "El administrador que quiere modificar no existe!";
			}
			if ($this->DB->Query("SELECT admId FROM administradores WHERE admId <> $this->Id AND admLogin = '$this->Login';")){
				$this->Errores['Login'] = "El administrador ya existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qModificar = "UPDATE administradores SET admNombre = '$this->Nombre', admApellido = '$this->Apellido', admEnabled ".
						  "= '$this->Enabled', admLogin = '$this->Login', admEmail = '$this->Email', admFecnac = '$this->Fecnac', admRoot = $this->Root ".
						  "WHERE admId = $this->Id;";
			$rModificar = $this->DB->Command($qModificar);
			
			if (!$rModificar){
				$this->Errores['Modificar'] = "Los datos del administrador no se modificaron."; return FALSE;
			}
			return TRUE;
		}
		function Borrar(){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al tratar de eliminar el administrador.';
				return FALSE;
			}
			if (! $this->DB->Command("DELETE FROM administradores WHERE admId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al tratar de eliminar el administrador.'; return FALSE;
			}
			return TRUE;
		}
		function changePassword($old, $new, $confirm){
			if (empty($new) || empty($confirm) || $new != $confirm){
				$this->Errores['Password'] = 'La nueva contrase�a no coincide con su confirmaci�n.'; return FALSE;
			}
			$qLogin = "SELECT admId FROM administradores WHERE admLogin = '$this->Login' AND admPassword = password('$old');";
			if (!$this->DB->Query($qLogin)){
				$this->Errores['Login'] = 'La contrase�a ingresada es incorrecta.'; return FALSE;
			}
			$result = $this->DB->Command("UPDATE administradores SET admPassword = password('$new') WHERE admLogin = '$this->Login'");
			if (!$result){
				$this->Errores['Password'] = 'La contrase�a no pudo cambiarse.'; return FALSE;
			}
			return TRUE;
		}
		function changePasswordDirect($new, $confirm){
			if (empty($new) || empty($confirm) || $new != $confirm){
				$this->Errores['Password'] = 'La nueva contrase�a no coincide con su confirmaci�n.'; return FALSE;
			}
			$result = $this->DB->Command("UPDATE administradores SET admPassword = password('$new') WHERE admLogin = '$this->Login'");
			if (!$result){
				$this->Errores['Password'] = 'La contrase�a no pudo cambiarse.'; return FALSE;
			}
			return TRUE;
		}
		function findId($valor){
			$this->clearAdministrador();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'Debe ser mayor que cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM administradores WHERE admId = $this->Id;");			
			if (!$result){
				$this->Errores['Id'] = 'El dministrador no existe!'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['admId'];
			$this->Nombre  = $datos['admNombre'];
			$this->Apellido= $datos['admApellido'];
			$this->Enabled = $datos['admEnabled'];
			$this->Login   = $datos['admLogin'];
			$this->Fecnac  = $datos['admFecnac'];
			$this->Email   = $datos['admEmail'];
			$this->Password= $datos['admPassword'];
			$this->Confirma= $datos['admPassword'];
			$this->Root    = $datos['admRoot'];

			return TRUE;
		}
//---------------------------------------------------------
		function checkIdentidad($email, $fecha, $ruta){
			$fecha = $this->DB->verifyDate($fecha);
			$s_adm = "SELECT admId as cod, admNombre as nom, admApellido as ape FROM administradores WHERE admEmail = '$email' AND admFecnac = '$fecha';";
			$r_adm = $this->DB->Query($s_adm);

			if ($r_adm){
				$a_persona = mysql_fetch_assoc($r_adm);
			} else {
				$this->Errores['Nueva_Contrasenia'] = 'Los datos ingresados no son correctos.';
			}
			if (!isset($this->Errores['Nueva_Contrasenia'])){
				$id_persona = $a_persona['cod'];
				$nm_persona = $a_persona['nom'].' '.$a_persona['ape'];

				$nueva_password = time();
				if ($this->DB->Command("UPDATE administradores SET admPassword = password('$nueva_password') WHERE admId = $id_persona;")){
					require_once $ruta.'class.mail.inc.php';

					$oMailForm = new clsMailForm();
					$oMailForm->setTitle  ('AZULCRED - Nueva contrase�a');
					$oMailForm->setSubject('AZULCRED - Nueva contrase�a');

					$oMailForm->setFrom($email, $nm_persona);
					$oMailForm->setTo  ($email);

					$_POST['nueva_password'] = $nueva_password;
					$campos = array('SUBTITLE1'=>'Azulcred - Nueva contrase�a','nueva_password'=>'Su nueva contrase�a');
	
					$oMailForm->setValores($_POST);
					$oMailForm->setCampos($campos);
					if (!$oMailForm->SendMail()){
						$this->Errores['Envio'] = 'No fue posible realizar el env�o. Por favor, intente m�s tarde.';
					}
				} else {$this->Errores['Nueva'] = 'Error durante el proceso.';}
			}
		}
//---------------------------------------------------------
		function clearErrores(){$this->Errores = array();}
		function hasErrores(){
			if (empty($this->Errores)){return FALSE;} else {return TRUE;}
		}
		function getErrores(){
			$error = '';
			foreach($this->Errores as $descripcion){$error .= $descripcion.'<br>';}
			return $error;
		}
//---------------------------------------------------------
		function setNombre($valor){
			$this->Nombre = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['Nombre'] = 'Complete el nombre.';
			}
		}
		function getNombre(){return $this->DB->forShow($this->Nombre);}
		function editNombre(){return $this->DB->forEdit($this->Nombre);}
//---------------------------------------------------------
		function setRoot($valor){ $this->Root = $valor; }
		function getRoot(){return $this->Root;}
//---------------------------------------------------------
		function setApellido($valor){
			$this->Apellido = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['Apellido'] = 'Complete el apellido.';
			}
		}
		function getApellido(){return $this->DB->forShow($this->Apellido);}
		function editApellido(){return $this->DB->forEdit($this->Apellido);}
//---------------------------------------------------------
		function setLogin($valor){
			if (trim($valor) != $valor){
				$this->Errores['Login'] = 'El Login no debe contener espacios al principio o al final.';
			}
			elseif (count(explode(" ", $valor))>1){
				$this->Errores['Login'] = 'El Login no debe contener espacios.';
			}
			$this->Login = strtolower($valor);

			if (empty($this->Login))
				$this->Errores['Login'] = 'Ingrese su nombre de usuario.';
		}
//----------------------------------------------------------
		function setEmail($valor){
			$this->Email = $this->DB->forSave($valor);
			$aValidacion = $this->DB->ValidarMail($valor);

			if ($aValidacion[0] == false){$this->Errores['Email'] = $aValidacion[1];}
		}
		function getEmail(){return $this->DB->forShow($this->Email);}
		function editEmail(){return $this->DB->forEdit($this->Email);}
//----------------------------------------------------------
		function setFecnac($valor){$this->Fecnac = $this->DB->verifyDate($valor);}
		function getFecnac(){return $this->DB->forShow($this->Fecnac);}
		function editFecnac(){return $this->DB->convertDate($this->Fecnac);}
//---------------------------------------------------------
		function setPassword($valor){
			if (trim($valor) != $valor){
				$this->Errores['Password'] = 'La Contrase�a no debe contener espacios al principio o al final.';
			}
			elseif (count(explode(" ", $valor))>1){
				$this->Errores['Password'] = 'La Contrase�a no debe contener espacios.';
			}
			$this->Password = $valor;
			if (empty($this->Password))
				$this->Errores['Password'] = 'Ingrese su Contrase�a.';
		}
//---------------------------------------------------------
		function setConfirma($valor){
			$this->Confirma = $valor;
			if (empty($this->Confirma))
				$this->Errores['Confirmacion'] = 'Complete la confirmaci�n.';
		}
//---------------------------------------------------------
		function setEnabled($valor){
			$this->Enabled = $valor;
			if ($this->Enabled != 'S'){$this->Enabled = 'N';}
		}
//---------------------------------------------------------
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Error interno.';}
		}
		function getId(){return $this->Id;}
//---------------------------------------------------------
		function doLogin($login, $password){
			$this->clearAdministrador();

			$this->setLogin($login);
			$this->setPassword($password);
			
			if ($this->hasErrores()){return FALSE;}

			$qLogin = "SELECT admId, admEnabled FROM administradores WHERE admLogin = '$this->Login' AND admPassword = password('$this->Password');";			
			$rLogin = $this->DB->Query($qLogin);

			if (!$rLogin){
				$this->Errores['Login'] = 'Por favor, ingrese correctamente sus datos.'.mysql_error(); return FALSE;
			}
			$datos = mysql_fetch_assoc($rLogin);
			if ($datos['admEnabled'] != 'S'){
				$this->Errores['Login'] = 'El administrador no est� habilitado.'; return FALSE;
			}
			if (!$this->findId($datos['admId'])){return FALSE;} return TRUE;
		}
//----------------------------------------------------------
	}
?>