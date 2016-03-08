<?php

/*
	Función encargada de remover palabras reservadas de una cadena
	Recibe: $string->Cadena a ser evaluada
*/
 function Clean_Sql($string){ 
	$wrong = array(";"=>" ","'"=>" ","alter"=>" ","ALTER"=>" ","drop"=>" ","DROP"=>" ",
                    "select"=>" ","SELECT"=>" ","from"=>" ","FROM"=>" "," and" =>" "," AND" =>" ",
                    "where"=>" ","WHERE"=>" ","insert"=>" ","INSERT"=>" ","delete"=>" ",
                    "DELETE"=>" ","*"=>" "," or"=>""," OR"=>"","%27"=>" ","table"=>" ","TABLE"=>" "); 
	$right = strtr($string,$wrong); 
	$right = strip_tags($right); 
	return $right;
 }

/*
	Función que realiza la encriptación de una cadena usando tipo Blowfish
	Recibe: $string->Cadena a ser encriptada
*/
function doBlowfish($string, $digito = 7) {
	$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$salt = sprintf('$2a$%02d$', $digito);
	for($i = 0; $i < 22; $i++){	
		$salt .= $set_salt[mt_rand(0, 22)];
	}
	return crypt($string, $salt);
}
 
/*
	Función para encriptar con Blowfish igual que Laravel
	Recibe: $value_>Cadena a ser encriptado
*/
function make($value, array $options = array())
	{
		$cost = 10;

		$hash = password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost));

		if ($hash === false)
		{
			echo "ERROR";
		}

		return $hash;
	}

/*
	Función para validar igualdad de dos cadenas
	Recibe: $value->Cadena que ingresa por formulario
			$hashedValue->Cadena encriptada
*/
function check($value, $hashedValue, array $options = array())
	{
		return password_verify($value, $hashedValue);
	}
?>