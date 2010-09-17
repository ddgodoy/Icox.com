<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsUsuarios
	{
		var $id = 0;
		var $empresa = '';
		var $nombre = '';
		var $apellido = '';
		var $ubicacion = '';
		var $direccion = '';
		var $telefono = '';
		var $celular = '';
		var $email = '';
		var $clave = '';
		var $habilitado = 0;
		var $creado = '';
		var $actualizado = '';
		var $Errores = array();
		var $DB;

		function clsUsuarios()
		{
			$this->clearUsuarios();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}

		function clearUsuarios()
		{
			$this->id = 0;
			$this->empresa = '';
			$this->nombre = '';
			$this->apellido = '';
			$this->ubicacion = '';
			$this->direccion = '';
			$this->telefono = '';
			$this->celular = '';
			$this->email = '';
			$this->clave = '';
			$this->creado = '';
			$this->habilitado = 0;
			$this->actualizado = '';
			$this->Errores= array();
		}

		function Validar()
		{
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}

		function Registrar()
		{
			if ($this->DB->Query("SELECT id FROM usuario WHERE email = '$this->email';")){
				$this->Errores['Modificar'] = "El usuario que quiere registrar ya existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO usuario (empresa, nombre, apellido, ubicacion, direccion, telefono, celular, email, clave, creado, actualizado, habilitado) ".
									 "VALUES ('$this->empresa', '$this->nombre', '$this->apellido', '$this->ubicacion', '$this->direccion', '$this->telefono', '$this->celular', ".
									 "'$this->email', MD5('$this->clave'), '$this->creado', '$this->actualizado', $this->habilitado);";

			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'El usuario no puede ser registrado.'; return FALSE;
			}
			$this->id = $this->DB->InsertId();

			return TRUE;
		}

		function Modificar()
		{
			if (!$this->DB->Query("SELECT id FROM usuario WHERE id = $this->id;")){
				$this->Errores['Modificar'] = "El usuario que quiere modificar no existe.";
			}
			if ($this->DB->Query("SELECT id FROM usuario WHERE email = '$this->email' AND id != $this->id;")) {
				$this->Errores['Modificar'] = "El usuario que quiere modificar ya se encuentra registrado.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE usuario SET empresa = '$this->empresa', nombre = '$this->nombre', apellido = '$this->apellido', ubicacion = ".
											"'$this->ubicacion', direccion = '$this->direccion', telefono = '$this->telefono', celular = '$this->celular', email ".
											"= '$this->email', actualizado = '$this->actualizado', habilitado = $this->habilitado WHERE id = $this->id;";

			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "El usuario no puede ser modificado."; return FALSE;
			}
			return TRUE;
		}

		function Borrar()
		{
			if ($this->id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar el usuario.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM usuario WHERE id = $this->id;")){
				$this->Errores['Borrar'] = 'Error al eliminar el usuario.'; return FALSE;
			}
			return TRUE;
		}

		function findId($valor)
		{
			$this->clearUsuarios();
			$this->id = (integer) $valor;

			if ($this->id <= 0){
				$this->Errores['Id'] = 'El Id debe ser mayor a cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM usuario WHERE id = $this->id;");

			if (!$result) {
				$this->Errores['Id'] = 'El usuario no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->id = $datos['id'];
			$this->empresa =  $datos['empresa'];
			$this->nombre = $datos['nombre'];
			$this->apellido = $datos['apellido'];
			$this->ubicacion = $datos['ubicacion'];
			$this->direccion = $datos['direccion'];
			$this->telefono = $datos['telefono'];
			$this->celular = $datos['celular'];
			$this->email = $datos['email'];
			$this->clave = $datos['clave'];
			$this->creado = $datos['creado'];
			$this->actualizado = $datos['actualizado'];
			$this->habilitado = $datos['habilitado'];

			return TRUE;
		}

		function clearErrores(){$this->Errores = array();}
		function hasErrores(){if (empty($this->Errores)){return FALSE;} else {return TRUE;}}
		function getErrores(){
			$error = '';
			foreach($this->Errores as $descripcion){$error .= $descripcion.'<br>';}
			return $error;
		}
//----------------------------------------------------------
		function setHabilitado($valor){$this->habilitado = $valor;}
		function getHabilitado(){return $this->habilitado;}
//----------------------------------------------------------
		function setEmpresa($valor){$this->empresa = $this->DB->forSave($valor);}
		function getEmpresa(){return $this->DB->forShow($this->empresa);}
		function editEmpresa(){return $this->DB->forEdit($this->empresa);}
//----------------------------------------------------------
		function setNombre($valor){
			$this->nombre = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['nombre'] = 'Complete el nombre.';
			}
		}
		function getNombre(){return $this->DB->forShow($this->nombre);}
		function editNombre(){return $this->DB->forEdit($this->nombre);}
//----------------------------------------------------------
		function setApellido($valor){
			$this->apellido = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['apellido'] = 'Complete el apellido.';
			}
		}
		function getApellido(){return $this->DB->forShow($this->apellido);}
		function editApellido(){return $this->DB->forEdit($this->apellido);}
//----------------------------------------------------------
		function setEmail($valor){
			$this->email = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['email'] = 'Complete el email.';
			}
		}
		function getEmail(){return $this->DB->forShow($this->email);}
		function editEmail(){return $this->DB->forEdit($this->email);}
//----------------------------------------------------------
		function setUbicacion($valor){$this->ubicacion = $this->DB->forSave($valor);}
		function getUbicacion(){return $this->DB->forShow($this->ubicacion);}
		function editUbicacion(){return $this->DB->forEdit($this->ubicacion);}
//----------------------------------------------------------
		function setDireccion($valor){$this->direccion = $this->DB->forSave($valor);}
		function getDireccion(){return $this->DB->forShow($this->direccion);}
		function editDireccion(){return $this->DB->forEdit($this->direccion);}
//----------------------------------------------------------
		function setTelefono($valor){$this->telefono = $this->DB->forSave($valor);}
		function getTelefono(){return $this->DB->forShow($this->telefono);}
		function editTelefono(){return $this->DB->forEdit($this->telefono);}
//----------------------------------------------------------
		function setCelular($valor){$this->celular = $this->DB->forSave($valor);}
		function getCelular(){return $this->DB->forShow($this->celular);}
		function editCelular(){return $this->DB->forEdit($this->celular);}
//----------------------------------------------------------
		function setClave($valor){
			$this->clave = $this->DB->forSave($valor);

			if (empty($valor)){
				$this->Errores['clave'] = 'Ingrese la clave.';
			}
		}
		function getClave(){return $this->clave;}
//----------------------------------------------------------
		function checkEmailRep($valor){
			if (empty($valor)) {
				$this->Errores['email_rep'] = 'Repita el email.';
			} elseif ($valor != $this->email) {
				$this->Errores['email_rep'] = 'Los emails deben ser iguales.';
			}
		}
//----------------------------------------------------------
		function checkClaveRep($valor){
			if (empty($valor)) {
				$this->Errores['clave_rep'] = 'Repita la clave.';
			} elseif ($valor != $this->clave) {
				$this->Errores['clave_rep'] = 'Las claves deben ser iguales.';
			}
		}
//----------------------------------------------------------
		function setCreado(){ $this->creado = date('Y-m-d H:i:s'); }
		function getCreado(){
			$xCreado = explode(' ', $this->creado);
			return $this->DB->convertDate($xCreado[0]);
		}
//----------------------------------------------------------
		function setActualizado(){ $this->actualizado = date('Y-m-d H:i:s'); }
		function getActualizado(){
			$xActualizado = explode(' ', $this->actualizado);
			return $this->DB->convertDate($xActualizado[0]);
		}
//----------------------------------------------------------
		function setId($valor){
			$this->id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Debe ingresar el id.';}
		}
		function getId(){return $this->id;}
//----------------------------------------------------------
		function updateClave($flag){
			if ($flag) {
				$this->DB->Command("UPDATE usuario SET clave = MD5('$this->clave') WHERE id = $this->id;");
			}
		}
//----------------------------------------------------------
		function sendInfoToUser($clave, $ruta)
		{			
			$this->findId($this->id);

			require_once $ruta.'class.mail.inc.php';
			
			$oMail = new clsMail();

			$oMail->to   = $this->email;
			$oMail->from = $_SESSION['_clienteAdminEmail'];
			$oMail->tema = 'GESTION DE DOMINIOS - Datos de acceso';
			
			$oMail->datos(
				array(
					'Nombre' => $this->nombre,
					'Apellido' => $this->apellido,
					'Empresa' => $this->empresa,
					'Direccion' => $this->direccion,
					'Telefono' => $this->telefono,
					'Celular' => $this->celular,
					'-EMAIL-' => $this->email,
					'-CLAVE-' => $clave,
					'-URL-' => 'http://www.icox.com/clientes/'
				)
			);
			@$oMail->enviar();
		}
//----------------------------------------------------------
		function doLogin($email, $password){
			$this->clearUsuarios();

			$this->setEmail($email);
			$this->setClave($password);
			
			if ($this->hasErrores()){return FALSE;}

			$qLogin = "SELECT * FROM usuario WHERE email = '$this->email' AND clave = MD5('$this->clave');";
			$rLogin = $this->DB->Query($qLogin);

			if (!$rLogin){
				$this->Errores['Login'] = 'Por favor, ingrese correctamente sus datos.'.mysql_error(); return FALSE;
			}
			$datos = mysql_fetch_assoc($rLogin);

			if ($datos['habilitado'] == 0){
				$this->Errores['Login'] = 'El cliente no se encuentra habilitado.'; return FALSE;
			}
			if (!$this->findId($datos['id'])){return FALSE;} return TRUE;
		}
//----------------------------------------------------------
		function getCuentaAdministrador()
		{
			$email = '';
			$r = $this->DB->Query("SELECT * FROM configurar;");
			if ($r) {
				$d = mysql_fetch_assoc($r);
				$email = $this->DB->forShow($d['email']);
			}
			return $email;
		}
//----------------------------------------------------------
	}
?>