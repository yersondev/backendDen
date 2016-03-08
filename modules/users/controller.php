<?php

header("Access-Control-Allow-Origin: *");
include_once("model.php");	// Incluye el Modelo.
$modelo = new User(); // Instancia a la clase del modelo
session_start();

try // Try, manejo de Errores
{
	$metodo = $_SERVER['REQUEST_METHOD'];
	$tipo_res = "";
	$response = null; 
	// Se manejaran dos tipos JSON y HTML
	// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
	// Por ahora solo POST, todas las llamadas se haran por POST
	$variables = $_POST;
	if(!isset($_POST['accion'])){echo "0"; return;} // Evita que ocurra un error si no manda accion.
	$accion = $variables['accion'];
	
	// Dependiendo de la accion se ejecutaran las tareas y se definira el tipo de respuesta.
	switch($accion) {
		case 'val_ses':
			 $tipo_res = 'HTML'; //Definir tipo de respuesta;
			 if(isset($_SESSION['id_us'])){
			 	$response = '1';
			 }else{
			 	$response = '0';
			 }
		break;
		case 'ValidateLog':
			 $username = $variables['username'];
			 $password = $variables['password'];
			 $tipo_res = 'JSON'; //Definir tipo de respuesta;
			 $response = $modelo->validateLogin($username, $password);
		break;
		case 'ListData':
			 $tipo_res = 'JSON';
			 $response = $modelo->listData();
		break;
		case 'RegisterUser':
			 $name = $variables['name'];
			 $doc = $variables['doc'];
			 $mun = $variables['mun'];
			 $dep = $variables['dep'];
			 $dateborn = $variables['dateborn'];
			 $sex = $variables['sex'];
			 $username = $variables['username'];
			 $password = $variables['password'];
			 $tipo_res = 'HTML'; //Definir tipo de respuesta;
			 $response = $modelo->registerUser($name,$doc,$mun,$dep,$dateborn,$sex,$username, $password);
		break;
	}

	// Respuestas del Controlador
	if($tipo_res == "JSON")
	{
	  echo json_encode($response); // $response será un array con los datos de nuestra respuesta.
	}
	elseif ($tipo_res == "HTML") {
	  echo $response; // $response será un html con el string de nuestra respuesta.
	}
} // Fin Try
catch (Exception $e) {}

