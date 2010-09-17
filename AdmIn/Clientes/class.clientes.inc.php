<?php
	require_once getLocal('COMMONS').'class.mysql.inc.php';

	class clsClientes{
		var $Id  = 0;
		var $Nombre = '';
		var $Orden  = 0;
		var $Errores= array();
		var $DB;

		function clsClientes(){
			$this->clearClientes();
			$this->DB = new clsMyDB();

			if ($this->DB->hasErrores()){$this->Errores = $this->DB->Errores;}
		}
		function clearClientes(){
			$this->Id  = 0;
			$this->Nombre = '';
			$this->Orden  = 0;
			$this->Errores= array();
		}
		function Validar(){
			if (empty($this->Errores)){return TRUE;} else {return FALSE;}
		}
		function Registrar(){
			if ($this->DB->Query("SELECT cliId FROM clientes WHERE cliNombre = '$this->Nombre';")){
				$this->Errores['Modificar'] = "El cliente que quiere registrar ya existe.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryInsert = "INSERT INTO clientes (cliNombre, cliOrden) VALUES ('$this->Nombre', $this->Orden);";
			$resInsert = $this->DB->Command($qryInsert);

			if (!$resInsert){
				$this->Errores['Registrar'] = 'El cliente no puede ser registrado.'; return FALSE;
			}
			$this->Id = $this->DB->InsertId();
			$this->checkOrden();

			return TRUE;
		}
		function Modificar(){
			if (!$this->DB->Query("SELECT cliId FROM clientes WHERE cliId = $this->Id;")){
				$this->Errores['Modificar'] = "El cliente que quiere modificar no existe.";
			}
			if ($this->DB->Query("SELECT cliId FROM clientes WHERE cliNombre = '$this->Nombre' AND cliId <> $this->Id;")){
				$this->Errores['Modificar'] = "El cliente que quiere modificar ya se encuentra registrado.";
			}
			if (!$this->Validar()){return FALSE;}

			$qryModificar = "UPDATE clientes SET cliNombre = '$this->Nombre', cliOrden = $this->Orden WHERE cliId = $this->Id;";
			$resModificar = $this->DB->Command($qryModificar);

			if (!$resModificar){
				$this->Errores['Modificar'] = "El cliente no puede ser modificado."; return FALSE;
			}
			$this->checkOrden();

			return TRUE;
		}
		function Borrar(){
			if ($this->Id <= 0){
				$this->Errores['Borrar'] = 'Error al eliminar el cliente.'; return FALSE;
			}
			if (!$this->DB->Command("DELETE FROM clientes WHERE cliId = $this->Id;")){
				$this->Errores['Borrar'] = 'Error al eliminar el cliente.'; return FALSE;
			}
			return TRUE;
		}
		function findId($valor){
			$this->clearClientes();
			$this->Id = (integer) $valor;

			if ($this->Id <= 0){
				$this->Errores['Id'] = 'El Id debe ser mayor a cero.'; return FALSE;
			}
			$result = $this->DB->Query("SELECT * FROM clientes WHERE cliId = $this->Id;");
			if (!$result){
				$this->Errores['Id'] = 'El cliente no existe.'; return FALSE;
			}
			$datos = mysql_fetch_assoc($result);

			$this->Id = $datos['cliId'];
			$this->Nombre = $datos['cliNombre'];
			$this->Orden  = $datos['cliOrden'];

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
		function setNombre($valor){
			$this->Nombre = $this->DB->forSave($valor);
			if (empty($valor)){
				$this->Errores['Nombre'] = 'Complete el nombre.';
			}
		}
		function getNombre(){return $this->DB->forShow($this->Nombre);}
		function editNombre(){return $this->DB->forEdit($this->Nombre);}
//----------------------------------------------------------
		function setOrden($valor){
			$this->Orden = (integer) $valor;
			if ($this->Orden == 0){
				$this->Errores['Orden'] = 'Indique un orden.';
			}
		}
		function getOrden(){return $this->Orden;}
//----------------------------------------------------------
		function setId($valor){
			$this->Id = (integer) $valor;
			if (empty($this->Id)){$this->Errores['Id'] = 'Debe ingresar el id.';}
		}
		function getId(){return $this->Id;}
//----------------------------------------------------------
		function checkOrden(){
			$res1 = $this->DB->Query("SELECT COUNT(cliId) as cuantos FROM clientes WHERE cliOrden = $this->Orden;");
			$dat1 = mysql_fetch_assoc($res1);

			if ($dat1['cuantos'] > 1){
				$ordn = 0;
				$res2 = $this->DB->Query("SELECT cliId, cliOrden FROM clientes WHERE cliId <> $this->Id ORDER BY cliOrden;");
				while ($res2 && $dat2 = mysql_fetch_assoc($res2)){
					$ordn++; $sId = $dat2['cliId']; $sOr = $dat2['cliOrden'];

					if ($sOr == $this->Orden){$ordn++;}
					$this->DB->Command("UPDATE clientes SET cliOrden = $ordn WHERE cliId = $sId;");
		}}}
//----------------------------------------------------------
	}
?>