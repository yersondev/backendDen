<?php

header("Access-Control-Allow-Origin: *");
include_once("model.php");	// Incluye el Modelo.
$modelo = new Complaint(); // Instancia a la clase del modelo
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
		case 'makeComplaint':
			 $dep = $variables['dep'];
			 $mun = $variables['mun'];
			 $adress = $variables['adress'];
			 $desc = $variables['desc'];
			 $tipo_res = 'JSON'; //Definir tipo de respuesta;
			 $response = $modelo->makeComplaint($dep, $mun, $adress, $desc);
		break;
		case 'listComplaints':
			 $tipo_res = 'JSON';
			 $response = $modelo->listComplaints();
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