<?php

include('../../abstract/connect.php');
include('../../abstract/functions.php');

class User extends Conexion{

	private $_connect;

	/*
		Constructor principal de la clase
		Crea una instancia de la clase Conexion
	*/
	function __construct(){
		$this->_connect = new Conexion();
	} 

	/*
		Mètodo para validar el inicio de sesión del usuario
		Recibe: $username-> Usuario digitado por el usuario
				$password-> Contraseña digitada por el usuario
	*/
	public function validateLogin($username, $password){
		$array = array();
		$clean_user = Clean_Sql($username); //Limpiar campo
		$clean_pass = Clean_Sql($password); //Limpiar campo
		$query = "SELECT * FROM den_users WHERE usname = '$clean_user' ";
		$result = $this->_connect->DoArraySQL($query);
		if(count($result) > 0){
			$pass_bd = $result['uspass'];
			$fin = check($clean_pass, $pass_bd); //Verificar contraseñas. Llamado al metodo check de functions	
			if($fin != false){
				session_start();
				$_SESSION['id_us'] = $result['id'];
				$array[] = $result;
			}
		}

		return $array;
		
	}

	public function listData(){
		$result = array();
		if (isset($_SESSION['id_us'])) {
			$id_us = $_SESSION['id_us'];
			$query = "SELECT * FROM den_users WHERE id = '$id_us' ";
			$result[] = $this->_connect->DoArraySQL($query);
		}
		return $result;
	}

	public function registerUser($name,$doc,$mun,$dep,$dateborn,$sex,$username, $password){
		$res = "";
		$clean_user = Clean_Sql($username);
		$clean_pass = Clean_Sql($password);
		$crypt_pass = doBlowfish($clean_pass);
		$query = "INSERT INTO den_users (name, doc, id_mun, id_dep, adress, dateBorn, sex, usname, uspass, date_create, time_create) VALUES ('$name','$doc','$mun','$dep','$dateborn','$sex','$clean_user','$crypt_pass','curdate()','curtime()')";
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
