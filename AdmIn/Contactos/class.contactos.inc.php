<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsContactos{
		var $Id = 0;
		var $Fecha    = '';
		var $Nombre   = '';
		var $Email    = '';
		var $Telefono = '';
		var $Pais     = '';
		var $Ciudad   = '';
		var $Direccion= '';
		var $Consulta = '';
		var $Errores  = array();
		var $DB;

		function clsContactos(){
			$this->clearContactos();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearContactos(){
			$this->Id = 0;
			$this->Fecha    = '';
			$this->Nombre   = '';
			$this->Email    = '';
			$this->Telefono = '';
			$this->Pais     = '';
			$this->Ciudad   = '';
			$this->Direccion= '';
			$this->Consulta = '';
			$this->Errores  = array();
		}
		function Validar(){
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO contactos (cntFecha, cntNombre, cntEmail, cntTelefono, cntPais, cntCiudad, ".
						 "cntDireccion, cntConsulta) VALUES ('$this->Fecha', '$this->Nombre', '$this->Email', '".
						 "$this->Telefono', '$this->Pais', '$this->Ciudad', '$this->Direccion', '$this->Consulta');";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'El contacto no puede ser registrado.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			return TRUE;
		}		
//		function Modificar(){
//			$result = $this->DB->Query("SELECT cntId FROM contactos WHERE cntId = $this->Id;");
//			if (!$result){
//				$this->Errores['Modificar'] = "El contacto no existe.";
//			}
//			if (!$this->Validar()){return FALSE;}
//
//			$qryModificar = "UPDATE contactos SET ganFecha = '$this->Fecha', ganNombre = '$this->Nombre', ganDomicilio = '$this->Domicilio', ".
//							"ganTelefono = '$this->Telefono', ganDni = '$this->Dni', ganPremio = '$this->Premio' WHERE cntId = $this->Id;";
//			$resModificar = $this->DB->Command($qryModificar);
//
//			if (!$resModificar){
//				$this->Errores['Modificar'] = "El contacto no puede ser modificado."; return FALSE;
//			}
//			return TRUE;
//		}
		function Borrar(){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al tratar de eliminar el contacto.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM contactos WHERE cntId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al tratar de eliminar el contacto.'; return FALSE;
			}
			return TRUE;
		}
		function findId($valor){
			$this->clearContactos();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'Error interno.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM contactos WHERE cntId = $this->Id;");
			if (! $result){
				$this->Errores['Id'] = 'El contacto no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['cntId'];
			$this->Fecha    = $datos['cntFecha'];
			$this->Nombre   = $datos['cntNombre'];
			$this->Email    = $datos['cntEmail'];
			$this->Telefono = $datos['cntTelefono'];
			$this->Pais     = $datos['cntPais'];
			$this->Ciudad   = $datos['cntCiudad'];
			$this->Direccion= $datos['cntDireccion'];
			$this->Consulta = $datos['cntConsulta'];

			return TRUE;
		}
//----------------------------------------------------------
		function clearErrores(){$this->Errores = array();}
		function hasErrores(){
			if (empty($this->Errores)){return FALSE;} else {return TRUE;}
		}
		function getErrores(){
			$error = '';
			foreach($this->Errores as $descripcion){$error .= $descripcion.'<br>';}
			return $error;
		}
//----------------------------------------------------------
		function setFecha($valor){$this->Fecha = $valor;}
		function getFecha(){return $this->DB->convertDate($this->Fecha);}
//----------------------------------------------------------
		function setNombre($valor){$this->Nombre = $this->DB->forSave($valor);}
		function getNombre(){return $this->DB->forShow($this->Nombre);}
		function editNombre(){return $this->DB->forEdit($this->Nombre);}
//----------------------------------------------------------
		function setEmail($valor){$this->Email = $this->DB->forSave($valor);}
		function getEmail(){return $this->DB->forShow($this->Email);}
		function editEmail(){return $this->DB->forEdit($this->Email);}
//----------------------------------------------------------
		function setTelefono($valor){$this->Telefono = $this->DB->forSave($valor);}
		function getTelefono(){return $this->DB->forShow($this->Telefono);}
		function editTelefono(){return $this->DB->forEdit($this->Telefono);}
//----------------------------------------------------------
		function setPais($valor){$this->Pais = $this->DB->forSave($valor);}
		function getPais(){return $this->DB->forShow($this->Pais);}
		function editPais(){return $this->DB->forEdit($this->Pais);}
//----------------------------------------------------------
		function setCiudad($valor){$this->Ciudad = $this->DB->forSave($valor);}
		function getCiudad(){return $this->DB->forShow($this->Ciudad);}
		function editCiudad(){return $this->DB->forEdit($this->Ciudad);}
//----------------------------------------------------------
		function setDireccion($valor){$this->Direccion = $this->DB->forSave($valor);}
		function getDireccion(){return $this->DB->forShow($this->Direccion);}
		function editDireccion(){return $this->DB->forEdit($this->Direccion);}
//----------------------------------------------------------
		function setConsulta($valor){$this->Consulta = $this->DB->forSave($valor);}
		function getConsulta(){return $this->DB->forShow($this->Consulta);}
		function editConsulta(){return $this->DB->forEdit($this->Consulta);}
//----------------------------------------------------------
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Error interno.';}
		}
		function getId(){return $this->Id;}
	}
?>