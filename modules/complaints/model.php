<?php

include('../../abstract/connect.php');
include('../../abstract/functions.php');

class Complaint extends Conexion{

	private $_connect;

	/*
		Constructor principal de la clase
		Crea una instancia de la clase Conexion
	*/
	function __construct(){
		$this->_connect = new Conexion();
	} 

	/*
		Metodo para retornar todas las 'complaints' de un usuario específico
		En este caso el usuario logueado
	*/
	public function listComplaints(){
		$result = array();
		if (isset($_SESSION['id_us'])) {
			$user = $_SESSION['id_us'];
			$query = "SELECT * FROM den_complaints WHERE id = '$user' ";
			$result[] = $this->_connect->DoArraySQL($query);
		}
		return $result;
	}

	/*
		Metodo para crear una nueva 'complaint'
		Recibe: $dep->El id del departamento
				$mun->El id del municipio
				$adress->La dirección exacta del 'complaint'
				$desc->Descripcion de la 'complaint'
	*/
	public function makeComplaint($dep, $mun, $adress, $desc){
		$res = "";
		$clean_adress = Clean_Sql($adress);
		$clean_desc = Clean_Sql($desc);
		$user = $_SESSION['id_us'];
		$query = "INSERT INTO den_complaints (id_dep, id_mun, adress, descrip, id_user, date_create, time_create) VALUES ('$$dep','$$mun','$clean_adress','$clean_desc','$user','curdate()','curtime()')";
		$result = $this->_connect->DoSql($query);
		if($result){
				$res = "1";
		}else{
			$res = "0";
		}
		return $res;
		
	}


}

?>