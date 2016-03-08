<?php

class Conexion {

	/* 
		Método para realizar la conexión a la base de datos
	*/
	public function EstablecerConexion()
	{
		 // Conectar con el servidor de base de datos
		 $conexion = mysqli_connect ("host", "user", "pass", "bd") or die ("No se puede conectar con el servidor MySQL");

		return $conexion;
	}

	/* 
		Método para consultas en la base de datos que devuelven los datos como un arreglo asociativo
		Recibe: $SentenciaSQL-> Sentencia en lenguaje SQL 
	*/
	public function DoArraySQL($SentenciaSQL){
		 try{
			 // Establecer Conexión Con el Servisor de Bases de Datos
			 $conexion=$this->EstablecerConexion();
			 // ejecutar la Sentencia SQL
			 $ejecutarOK = mysqli_query($conexion,$SentenciaSQL) or die ("Fallo en la insercion en la base de datos ".mysqli_error($conexion).'<br><br>' );
			 $result = $ejecutarOK->fetch_array(MYSQLI_ASSOC);
			// Cerrar conexión
			 mysqli_close($conexion);

			 return $result;
		 }
		 catch(Exception $e){
			 $_mensaje = "Se presento el siguiente Error: " . $e->getMessage();
		 }
	}

	/* 
		Método para consultas en la base de datos que devuelven los datos normalmente
		Recibe: $query-> Sentencia en lenguaje SQL 
	*/
	public function DoSql($query){
		try{
			 // Establecer Conexión Con el Servisor de Bases de Datos
			 $conexion=$this->EstablecerConexion();
			 // ejecutar la Sentencia SQL
			 $ejecutarOK = mysqli_query($conexion,$query) or die ("Fallo en la insercion en la base de datos ".mysqli_error($conexion).'<br><br>' );
			// Cerrar conexión
			 mysqli_close($conexion);

			 return $ejecutarOK;
		 }
		 catch(Exception $e){
			 $_mensaje = "Se presento el siguiente Error: " . $e->getMessage();
		 }
	}
}


?>