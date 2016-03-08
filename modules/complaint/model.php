<?php

include('../../abstract/connect.php');
include('../../abstract/functions.php');

class Complaint extends Conexion{

	private $_connect;

	function __construct(){
		$this->_connect = new Conexion();
	} 

	public function listComplaints(){
		$result = array();
		if (isset($_SESSION['id_us'])) {
			$user = $_SESSION['id_us'];
			$query = "SELECT * FROM den_complaints WHERE id = '$user' ";
			$result[] = $this->_connect->DoArraySQL($query);
		}
		return $result;
	}

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