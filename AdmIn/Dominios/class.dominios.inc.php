<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsDominios
	{
		var $id = 0;
		var $usuario_id = 0;
		var $dominio = '';
		var $dns_primario = '';
		var $dns_secundario = '';
		var $ip_primario = '';
		var $ip_secundario = '';
		var $reg_pais = '';
		var $reg_provincia = '';
		var $reg_ciudad = '';
		var $reg_codigo_postal = '';
		var $reg_direccion = '';
		var $reg_telefono = '';
		var $reg_email = '';
		var $reg_nombre = '';
		var $reg_apellido = '';
		var $reg_empresa = '';
		var $adm_pais = '';
		var $adm_provincia = '';
		var $adm_ciudad = '';
		var $adm_codigo_postal = '';
		var $adm_direccion = '';
		var $adm_telefono = '';
		var $adm_email = '';
		var $adm_nombre = '';
		var $adm_apellido = '';
		var $adm_empresa = '';
		var $tec_pais = '';
		var $tec_provincia = '';
		var $tec_ciudad = '';
		var $tec_codigo_postal = '';
		var $tec_direccion = '';
		var $tec_telefono = '';
		var $tec_email = '';
		var $tec_nombre = '';
		var $tec_apellido = '';
		var $tec_empresa = '';
		var $creado = '';
		var $actualizado = '';
		var $Errores = array();
		var $DB;

		function clsDominios()
		{
			$this->clearDominios();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}

		function clearDominios()
		{
			$this->id = 0;
			$this->usuario_id = 0;
			$this->dominio = '';
			$this->dns_primario = '';
			$this->dns_secundario = '';
			$this->ip_primario = '';
			$this->ip_secundario = '';
			$this->reg_pais = '';
			$this->reg_provincia = '';
			$this->reg_ciudad = '';
			$this->reg_codigo_postal = '';
			$this->reg_direccion = '';
			$this->reg_telefono = '';
			$this->reg_email = '';
			$this->reg_nombre = '';
			$this->reg_apellido = '';
			$this->reg_empresa = '';
			$this->adm_pais = '';
			$this->adm_provincia = '';
			$this->adm_ciudad = '';
			$this->adm_codigo_postal = '';
			$this->adm_direccion = '';
			$this->adm_telefono = '';
			$this->adm_email = '';
			$this->adm_nombre = '';
			$this->adm_apellido = '';
			$this->adm_empresa = '';
			$this->tec_pais = '';
			$this->tec_provincia = '';
			$this->tec_ciudad = '';
			$this->tec_codigo_postal = '';
			$this->tec_direccion = '';
			$this->tec_telefono = '';
			$this->tec_email = '';
			$this->tec_nombre = '';
			$this->tec_apellido = '';
			$this->tec_empresa = '';
			$this->creado = '';
			$this->actualizado = '';
			$this->Errores= array();
		}

		function Validar()
		{
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}

		function Registrar()
		{
			if ($this->DB->Query("SELECT id FROM dominio WHERE dominio = '$this->dominio';")){
				$this->Errores['Modificar'] = "El dominio que quiere registrar ya existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO dominio (usuario_id, dominio, dns_primario, dns_secundario, ip_primario, ip_secundario, reg_pais, reg_provincia, reg_ciudad, ".
									 "reg_codigo_postal, reg_direccion, reg_telefono, reg_email, reg_nombre, reg_apellido, reg_empresa, adm_pais, adm_provincia, adm_ciudad, ".
									 "adm_codigo_postal, adm_direccion, adm_telefono, adm_email, adm_nombre, adm_apellido, adm_empresa, tec_pais, tec_provincia, tec_ciudad, ".
									 "tec_codigo_postal, tec_direccion, tec_telefono, tec_email, tec_nombre, tec_apellido, tec_empresa, creado, actualizado) VALUES (".
									 "$this->usuario_id, '$this->dominio', '$this->dns_primario', '$this->dns_secundario', '$this->ip_primario', '$this->ip_secundario', ".
									 "'$this->reg_pais', '$this->reg_provincia', '$this->reg_ciudad', '$this->reg_codigo_postal', '$this->reg_direccion', '$this->reg_telefono', ".
									 "'$this->reg_email', '$this->reg_nombre', '$this->reg_apellido', '$this->reg_empresa', '$this->adm_pais', '$this->adm_provincia', ".
									 "'$this->adm_ciudad', '$this->adm_codigo_postal', '$this->adm_direccion', '$this->adm_telefono', '$this->adm_email', '$this->adm_nombre', ".
									 "'$this->adm_apellido', '$this->adm_empresa', '$this->tec_pais', '$this->tec_provincia', '$this->tec_ciudad', '$this->tec_codigo_postal', ".
									 "'$this->tec_direccion', '$this->tec_telefono', '$this->tec_email', '$this->tec_nombre', '$this->tec_apellido', '$this->tec_empresa', ".
									 "'$this->creado', '$this->actualizado');";

			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'El dominio no puede ser registrado.'; return FALSE;
			}
			$this->id = $this->DB->InsertId();

			return TRUE;
		}

		function Modificar()
		{
			if (!$this->DB->Query("SELECT id FROM dominio WHERE id = $this->id;")){
				$this->Errores['Modificar'] = "El dominio que quiere modificar no existe.";
			}
			if ($this->DB->Query("SELECT id FROM dominio WHERE dominio = '$this->dominio' AND id != $this->id;")) {
				$this->Errores['Modificar'] = "El dominio que quiere modificar ya se encuentra registrado.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE dominio SET usuario_id = $this->usuario_id, dominio = '$this->dominio', dns_primario = '$this->dns_primario', ".
											"dns_secundario = '$this->dns_secundario', ip_primario = '$this->ip_primario', ip_secundario = '$this->ip_secundario', ".
											"reg_pais = '$this->reg_pais', reg_provincia = '$this->reg_provincia', reg_ciudad = '$this->reg_ciudad', reg_codigo_postal = ".
											"'$this->reg_codigo_postal', reg_direccion = '$this->reg_direccion', reg_telefono = '$this->reg_telefono', reg_email = ".
											"'$this->reg_email', reg_nombre = '$this->reg_nombre', reg_apellido = '$this->reg_apellido', reg_empresa = '$this->reg_empresa', ".
											"adm_pais = '$this->adm_pais', adm_provincia = '$this->adm_provincia', adm_ciudad = '$this->adm_ciudad', adm_codigo_postal = ".
											"'$this->adm_codigo_postal', adm_direccion = '$this->adm_direccion', adm_telefono = '$this->adm_telefono', adm_email = ".
											"'$this->adm_email', adm_nombre = '$this->adm_nombre', adm_apellido = '$this->adm_apellido', adm_empresa = '$this->adm_empresa', ".
											"tec_pais = '$this->tec_pais', tec_provincia = '$this->tec_provincia', tec_ciudad = '$this->tec_ciudad', tec_codigo_postal = ".
											"'$this->tec_codigo_postal', tec_direccion = '$this->tec_direccion', tec_telefono = '$this->tec_telefono', tec_email = ".
											"'$this->tec_email', tec_nombre = '$this->tec_nombre', tec_apellido = '$this->tec_apellido', tec_empresa = '$this->tec_empresa', ".
											"actualizado = '$this->actualizado' WHERE id = $this->id;";

			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "El dominio no puede ser modificado."; return FALSE;
			}
			return TRUE;
		}

		function Borrar()
		{
			if ($this->id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar el dominio.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM dominio WHERE id = $this->id;")){
				$this->Errores['Borrar'] = 'Error al eliminar el dominio.'; return FALSE;
			}
			return TRUE;
		}

		function findId($valor)
		{
			$this->clearDominios();
			$this->id = (integer) $valor;

			if ($this->id <= 0){
				$this->Errores['Id'] = 'El Id debe ser mayor a cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM dominio WHERE id = $this->id;");

			if (!$result) {
				$this->Errores['Id'] = 'El dominio no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->id = $datos['id'];
			$this->usuario_id = $datos['usuario_id'];
			$this->dominio = $datos['dominio'];
			$this->dns_primario = $datos['dns_primario'];
			$this->dns_secundario = $datos['dns_secundario'];
			$this->ip_primario = $datos['ip_primario'];
			$this->ip_secundario = $datos['ip_secundario'];
			$this->reg_pais = $datos['reg_pais'];
			$this->reg_provincia = $datos['reg_provincia'];
			$this->reg_ciudad = $datos['reg_ciudad'];
			$this->reg_codigo_postal = $datos['reg_codigo_postal'];
			$this->reg_direccion = $datos['reg_direccion'];
			$this->reg_telefono = $datos['reg_telefono'];
			$this->reg_email = $datos['reg_email'];
			$this->reg_nombre = $datos['reg_nombre'];
			$this->reg_apellido = $datos['reg_apellido'];
			$this->reg_empresa = $datos['reg_empresa'];
			$this->adm_pais = $datos['adm_pais'];
			$this->adm_provincia = $datos['adm_provincia'];
			$this->adm_ciudad = $datos['adm_ciudad'];
			$this->adm_codigo_postal = $datos['adm_codigo_postal'];
			$this->adm_direccion = $datos['adm_direccion'];
			$this->adm_telefono = $datos['adm_telefono'];
			$this->adm_email = $datos['adm_email'];
			$this->adm_nombre = $datos['adm_nombre'];
			$this->adm_apellido = $datos['adm_apellido'];
			$this->adm_empresa = $datos['adm_empresa'];
			$this->tec_pais = $datos['tec_pais'];
			$this->tec_provincia = $datos['tec_provincia'];
			$this->tec_ciudad = $datos['tec_ciudad'];
			$this->tec_codigo_postal = $datos['tec_codigo_postal'];
			$this->tec_direccion = $datos['tec_direccion'];
			$this->tec_telefono = $datos['tec_telefono'];
			$this->tec_email = $datos['tec_email'];
			$this->tec_nombre = $datos['tec_nombre'];
			$this->tec_apellido = $datos['tec_apellido'];
			$this->tec_empresa = $datos['tec_empresa'];
			$this->creado = $datos['creado'];
			$this->actualizado = $datos['actualizado'];

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
		function setUsuarioId($valor){
			$this->usuario_id = $valor;
			if (empty($valor)){
				$this->Errores['usuario'] = 'Seleccione un usuario.';
			}
		}
		function getUsuarioId(){return $this->usuario_id;}
//----------------------------------------------------------
		function setDominio($valor){
			$this->dominio = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['dominio'] = 'Complete el dominio.';
			}
		}
		function getDominio(){return $this->DB->forShow($this->dominio);}
		function editDominio(){return $this->DB->forEdit($this->dominio);}
//----------------------------------------------------------
		function setDnsPrimario($valor){$this->dns_primario = $this->DB->forSave($valor);}
		function getDnsPrimario(){return $this->DB->forShow($this->dns_primario);}
		function editDnsPrimario(){return $this->DB->forEdit($this->dns_primario);}
//----------------------------------------------------------
		function setDnsSecundario($valor){$this->dns_secundario = $this->DB->forSave($valor);}
		function getDnsSecundario(){return $this->DB->forShow($this->dns_secundario);}
		function editDnsSecundario(){return $this->DB->forEdit($this->dns_secundario);}
//----------------------------------------------------------
		function setIpPrimario($valor){$this->ip_primario = $this->DB->forSave($valor);}
		function getIpPrimario(){return $this->DB->forShow($this->ip_primario);}
		function editIpPrimario(){return $this->DB->forEdit($this->ip_primario);}
//----------------------------------------------------------
		function setIpSecundario($valor){$this->ip_secundario = $this->DB->forSave($valor);}
		function getIpSecundario(){return $this->DB->forShow($this->ip_secundario);}
		function editIpSecundario(){return $this->DB->forEdit($this->ip_secundario);}
//----------------------------------------------------------
		function setRegPais($valor){$this->reg_pais = $this->DB->forSave($valor);}
		function getRegPais(){return $this->DB->forShow($this->reg_pais);}
		function editRegPais(){return $this->DB->forEdit($this->reg_pais);}
		
		function setRegProvincia($valor){$this->reg_provincia = $this->DB->forSave($valor);}
		function getRegProvincia(){return $this->DB->forShow($this->reg_provincia);}
		function editRegProvincia(){return $this->DB->forEdit($this->reg_provincia);}

		function setRegCiudad($valor){$this->reg_ciudad = $this->DB->forSave($valor);}
		function getRegCiudad(){return $this->DB->forShow($this->reg_ciudad);}
		function editRegCiudad(){return $this->DB->forEdit($this->reg_ciudad);}
		
		function setRegCodigoPostal($valor){$this->reg_codigo_postal = $this->DB->forSave($valor);}
		function getRegCodigoPostal(){return $this->DB->forShow($this->reg_codigo_postal);}
		function editRegCodigoPostal(){return $this->DB->forEdit($this->reg_codigo_postal);}
		
		function setRegDireccion($valor){$this->reg_direccion = $this->DB->forSave($valor);}
		function getRegDireccion(){return $this->DB->forShow($this->reg_direccion);}
		function editRegDireccion(){return $this->DB->forEdit($this->reg_direccion);}
		
		function setRegTelefono($valor){$this->reg_telefono = $this->DB->forSave($valor);}
		function getRegTelefono(){return $this->DB->forShow($this->reg_telefono);}
		function editRegTelefono(){return $this->DB->forEdit($this->reg_telefono);}
		
		function setRegEmail($valor){$this->reg_email = $this->DB->forSave($valor);}
		function getRegEmail(){return $this->DB->forShow($this->reg_email);}
		function editRegEmail(){return $this->DB->forEdit($this->reg_email);}
		
		function setRegNombre($valor){$this->reg_nombre = $this->DB->forSave($valor);}
		function getRegNombre(){return $this->DB->forShow($this->reg_nombre);}
		function editRegNombre(){return $this->DB->forEdit($this->reg_nombre);}
		
		function setRegApellido($valor){$this->reg_apellido = $this->DB->forSave($valor);}
		function getRegApellido(){return $this->DB->forShow($this->reg_apellido);}
		function editRegApellido(){return $this->DB->forEdit($this->reg_apellido);}
		
		function setRegEmpresa($valor){$this->reg_empresa = $this->DB->forSave($valor);}
		function getRegEmpresa(){return $this->DB->forShow($this->reg_empresa);}
		function editRegEmpresa(){return $this->DB->forEdit($this->reg_empresa);}
//----------------------------------------------------------
		function setAdmPais($valor){$this->adm_pais = $this->DB->forSave($valor);}
		function getAdmPais(){return $this->DB->forShow($this->adm_pais);}
		function editAdmPais(){return $this->DB->forEdit($this->adm_pais);}
		
		function setAdmProvincia($valor){$this->adm_provincia = $this->DB->forSave($valor);}
		function getAdmProvincia(){return $this->DB->forShow($this->adm_provincia);}
		function editAdmProvincia(){return $this->DB->forEdit($this->adm_provincia);}

		function setAdmCiudad($valor){$this->adm_ciudad = $this->DB->forSave($valor);}
		function getAdmCiudad(){return $this->DB->forShow($this->adm_ciudad);}
		function editAdmCiudad(){return $this->DB->forEdit($this->adm_ciudad);}
		
		function setAdmCodigoPostal($valor){$this->adm_codigo_postal = $this->DB->forSave($valor);}
		function getAdmCodigoPostal(){return $this->DB->forShow($this->adm_codigo_postal);}
		function editAdmCodigoPostal(){return $this->DB->forEdit($this->adm_codigo_postal);}
		
		function setAdmDireccion($valor){$this->adm_direccion = $this->DB->forSave($valor);}
		function getAdmDireccion(){return $this->DB->forShow($this->adm_direccion);}
		function editAdmDireccion(){return $this->DB->forEdit($this->adm_direccion);}
		
		function setAdmTelefono($valor){$this->adm_telefono = $this->DB->forSave($valor);}
		function getAdmTelefono(){return $this->DB->forShow($this->adm_telefono);}
		function editAdmTelefono(){return $this->DB->forEdit($this->adm_telefono);}
		
		function setAdmEmail($valor){$this->adm_email = $this->DB->forSave($valor);}
		function getAdmEmail(){return $this->DB->forShow($this->adm_email);}
		function editAdmEmail(){return $this->DB->forEdit($this->adm_email);}
		
		function setAdmNombre($valor){$this->adm_nombre = $this->DB->forSave($valor);}
		function getAdmNombre(){return $this->DB->forShow($this->adm_nombre);}
		function editAdmNombre(){return $this->DB->forEdit($this->adm_nombre);}
		
		function setAdmApellido($valor){$this->adm_apellido = $this->DB->forSave($valor);}
		function getAdmApellido(){return $this->DB->forShow($this->adm_apellido);}
		function editAdmApellido(){return $this->DB->forEdit($this->adm_apellido);}
		
		function setAdmEmpresa($valor){$this->adm_empresa = $this->DB->forSave($valor);}
		function getAdmEmpresa(){return $this->DB->forShow($this->adm_empresa);}
		function editAdmEmpresa(){return $this->DB->forEdit($this->adm_empresa);}
//----------------------------------------------------------
		function setTecPais($valor){$this->tec_pais = $this->DB->forSave($valor);}
		function getTecPais(){return $this->DB->forShow($this->tec_pais);}
		function editTecPais(){return $this->DB->forEdit($this->tec_pais);}
		
		function setTecProvincia($valor){$this->tec_provincia = $this->DB->forSave($valor);}
		function getTecProvincia(){return $this->DB->forShow($this->tec_provincia);}
		function editTecProvincia(){return $this->DB->forEdit($this->tec_provincia);}

		function setTecCiudad($valor){$this->tec_ciudad = $this->DB->forSave($valor);}
		function getTecCiudad(){return $this->DB->forShow($this->tec_ciudad);}
		function editTecCiudad(){return $this->DB->forEdit($this->tec_ciudad);}
		
		function setTecCodigoPostal($valor){$this->tec_codigo_postal = $this->DB->forSave($valor);}
		function getTecCodigoPostal(){return $this->DB->forShow($this->tec_codigo_postal);}
		function editTecCodigoPostal(){return $this->DB->forEdit($this->tec_codigo_postal);}
		
		function setTecDireccion($valor){$this->tec_direccion = $this->DB->forSave($valor);}
		function getTecDireccion(){return $this->DB->forShow($this->tec_direccion);}
		function editTecDireccion(){return $this->DB->forEdit($this->tec_direccion);}
		
		function setTecTelefono($valor){$this->tec_telefono = $this->DB->forSave($valor);}
		function getTecTelefono(){return $this->DB->forShow($this->tec_telefono);}
		function editTecTelefono(){return $this->DB->forEdit($this->tec_telefono);}
		
		function setTecEmail($valor){$this->tec_email = $this->DB->forSave($valor);}
		function getTecEmail(){return $this->DB->forShow($this->tec_email);}
		function editTecEmail(){return $this->DB->forEdit($this->tec_email);}
		
		function setTecNombre($valor){$this->tec_nombre = $this->DB->forSave($valor);}
		function getTecNombre(){return $this->DB->forShow($this->tec_nombre);}
		function editTecNombre(){return $this->DB->forEdit($this->tec_nombre);}
		
		function setTecApellido($valor){$this->tec_apellido = $this->DB->forSave($valor);}
		function getTecApellido(){return $this->DB->forShow($this->tec_apellido);}
		function editTecApellido(){return $this->DB->forEdit($this->tec_apellido);}
		
		function setTecEmpresa($valor){$this->tec_empresa = $this->DB->forSave($valor);}
		function getTecEmpresa(){return $this->DB->forShow($this->tec_empresa);}
		function editTecEmpresa(){return $this->DB->forEdit($this->tec_empresa);}
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
		function getUsuarios()
		{
			$aResult = array('-- seleccionar --');
			$oResult = $this->DB->Query("SELECT id, apellido, nombre FROM usuario ORDER BY apellido;");

			while ($oResult && $dResult = mysql_fetch_assoc($oResult)) {
				$aResult[$dResult['id']] = $this->DB->forShow($dResult['apellido'].', '.$dResult['nombre']);
			}
			return $aResult;
		}
//----------------------------------------------------------
		function setDnsAlternativos($dns, $ip)
		{
			$this->DB->Command("DELETE FROM dns_alternativo WHERE dominio_id = $this->id;");
			
			foreach ($dns as $key => $value) {
				$xDns = $dns[$key];
				$xIp = $ip[$key];

				$this->DB->Command("INSERT INTO dns_alternativo (dominio_id, dns, ip) VALUES ($this->id, '$xDns', '$xIp');");
			}
		}
//----------------------------------------------------------
		function getDnsAlternativos()
		{
			$aDns = array();
			$aIp = array();
			$oResult = $this->DB->Query("SELECT * FROM dns_alternativo WHERE dominio_id = $this->id;");
			
			$c = 0; while ($oResult && $dResult = mysql_fetch_assoc($oResult)) {
				$aDns[$c] = $dResult['dns'];
				$aIp[$c] = $dResult['ip'];

				$c++;
			}
			return array('dns'=>$aDns, 'ip'=>$aIp);
		}
//----------------------------------------------------------
		function preserveValuesInSession($aDns, $aIp)
		{
			unset($_SESSION['_clientePreserve']);

			$preserve = array(
				'dominio' => $this->getDominio(), 'dns_primario' => $this->getDnsPrimario(), 'dns_secundario' => $this->getDnsSecundario(),
				'ip_primario' => $this->getIpPrimario(), 'ip_secundario' => $this->getIpSecundario(), 'reg_pais' => $this->getRegPais(),
				'reg_provincia' => $this->getRegProvincia(), 'reg_ciudad' => $this->getRegCiudad(), 'reg_codigo_postal' => $this->getRegCodigoPostal(), 
				'reg_direccion' => $this->getRegDireccion(), 'reg_telefono' => $this->getRegTelefono(), 'reg_email' => $this->getRegEmail(),
				'reg_nombre' => $this->getRegNombre(), 'reg_apellido' => $this->getRegApellido(), 'reg_empresa' => $this->getRegEmpresa(),
				'adm_pais' => $this->getAdmPais(), 'adm_provincia' => $this->getAdmProvincia(), 'adm_ciudad' => $this->getAdmCiudad(),
				'adm_codigo_postal' => $this->getAdmCodigoPostal(), 'adm_direccion' => $this->getAdmDireccion(), 'adm_telefono' => $this->getAdmTelefono(),
				'adm_email' => $this->getAdmEmail(), 'adm_nombre' => $this->getAdmNombre(), 'adm_apellido' => $this->getAdmApellido(),
				'adm_empresa' => $this->getAdmEmpresa(), 'tec_pais' => $this->getTecPais(), 'tec_provincia' => $this->getTecProvincia(),
				'tec_ciudad' => $this->getTecCiudad(), 'tec_codigo_postal' => $this->getTecCodigoPostal(), 'tec_direccion' => $this->getTecDireccion(),
				'tec_telefono' => $this->getTecTelefono(), 'tec_email' => $this->getTecEmail(), 'tec_nombre' => $this->getTecNombre(),
				'tec_apellido' => $this->getTecApellido(), 'tec_empresa' => $this->getTecEmpresa(), 'dns_alternativos' => $aDns, 'ip_alternativos' => $aIp
			);
			$labels = array(
				'dominio' => 'Nombre dominio', 'dns_primario' => 'DNS primario', 'dns_secundario' => 'DNS secundario', 'ip_primario' => 'IP primario', 
				'ip_secundario' => 'IP secundario', 'reg_pais' => 'Pais (registrante)', 'reg_provincia' => 'Provincia (registrante)', 
				'reg_ciudad' => 'Ciudad (registrante)', 'reg_codigo_postal' => 'C.P. (registrante)', 'reg_direccion' => 'Direccion (registrante)', 
				'reg_telefono' => 'Telefono (registrante)', 'reg_email' => 'Email (registrante)', 'reg_nombre' => 'Nombre (registrante)', 
				'reg_apellido' => 'Apellido (registrante)', 'reg_empresa' => 'Empresa (registrante)', 'adm_pais' => 'Pais (administrativo)', 
				'adm_provincia' => 'Provincia (administrativo)', 'adm_ciudad' => 'Ciudad (administrativo)', 'adm_codigo_postal' => 'C.P. (administrativo)', 
				'adm_direccion' => 'Direccion (administrativo)', 'adm_telefono' => 'Telefono (administrativo)', 'adm_email' => 'Email (administrativo)', 
				'adm_nombre' => 'Nombre (administrativo)', 'adm_apellido' => 'Apellido (administrativo)', 'adm_empresa' => 'Empresa (administrativo)', 
				'tec_pais' => 'Pais (tecnico)', 'tec_provincia' => 'Provincia (tecnico)', 'tec_ciudad' => 'Ciudad (tecnico)', 
				'tec_codigo_postal' => 'C.P. (tecnico)', 'tec_direccion' => 'Direccion (tecnico)', 'tec_telefono' => 'Telefono (tecnico)', 
				'tec_email' => 'Email (tecnico)', 'tec_nombre' => 'Nombre (tecnico)', 'tec_apellido' => 'Apellido (tecnico)', 
				'tec_empresa' => 'Empresa (tecnico)', 'dns_alternativos' => 'DNS alternativos', 'ip_alternativos' => 'IP alternativos'
			);
			$_SESSION['_clientePreserve'] = array('campos' => $preserve, 'labels' => $labels);
		}
//----------------------------------------------------------
		function clienteHizoCambios()
		{
			$respuesta = false;
			$aCambios = array();

			$aDns = $_SESSION['_clientePreserve']['campos']['dns_alternativos'];
			$aIp = $_SESSION['_clientePreserve']['campos']['ip_alternativos'];

			unset($_SESSION['_clientePreserve']['campos']['dns_alternativos']);
			unset($_SESSION['_clientePreserve']['campos']['ip_alternativos']);

			$auxAlternativos = $this->getDnsAlternativos();

			$countDns1 = count($aDns);
			$countDns2 = count($auxAlternativos['dns']);

			if ($countDns1 != $countDns2) {
				$aCambios[] = 'dns_alternativos';
			} else {
				if ($countDns1 > 0) {
					foreach ($aDns as $k_dns1 => $v_dns1) {
						if (!in_array($aDns[$k_dns1], $auxAlternativos['dns'])) {
							$aCambios[] = 'dns_alternativos'; break;
						}
						elseif (!in_array($aIp[$k_dns1], $auxAlternativos['ip'])) {
							$aCambios[] = 'ip_alternativos'; break;
			}}}}
			foreach ($_SESSION['_clientePreserve']['campos'] as $k_p => $v_p) {
				if ($this->$k_p != $v_p) { $aCambios[] = $k_p; }
			}
			if (count($aCambios) > 0) {
				$respuesta = true;
				$fechahora = date('Y-m-d H:i:s');

				foreach ($aCambios as $v_cambio) {
					$xLabel = $_SESSION['_clientePreserve']['labels'][$v_cambio];

					$this->DB->Command("INSERT INTO dominio_cambio (dominio_id, campo, titulo, creado) VALUES ($this->id, '$v_cambio', '$xLabel', '$fechahora');");
				}
			}
			return $respuesta;
		}
//----------------------------------------------------------
		function sendMailToAdmin($nombre_dominio, $ruta)
		{
			$a = array();
			$r = $this->DB->Query("SELECT * FROM dominio_cambio WHERE dominio_id = $this->id GROUP BY campo ORDER BY creado;");

			if ($r) { while ($d = mysql_fetch_assoc($r)) { $a[$d['titulo']] = $d['creado']; } }
			//
			if (count($a) > 0) {
				require_once $ruta.'class.mail.inc.php';

				$oMail = new clsMail();
	
				$oMail->to   = $_SESSION['_clienteAdminEmail'];
				$oMail->from = $_SESSION['_clienteAdminEmail'];
				$oMail->tema = "Cambios en el dominio $nombre_dominio del cliente ".$_SESSION['_clienteNombre']." en fecha ".date('d/m/Y');
				
				$oMail->datos($a);
				@$oMail->enviar();
			}
		}
//----------------------------------------------------------
		function getCambiosDelUsuario()
		{
			$a = array();
			$r = $this->DB->Query("SELECT * FROM dominio_cambio WHERE dominio_id = $this->id GROUP BY campo ORDER BY creado;");

			if ($r) { while ($d = mysql_fetch_assoc($r)) { $a[$d['campo']] = true; } }

			return $a;
		}
//----------------------------------------------------------
		function clearCambiosDelUsuario()
		{
			$this->DB->Command("DELETE FROM dominio_cambio WHERE dominio_id = $this->id;");
		}
//----------------------------------------------------------
	}
?>