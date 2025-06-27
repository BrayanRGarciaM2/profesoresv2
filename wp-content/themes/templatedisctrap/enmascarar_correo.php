<?php

/***
* Método permite enmascarar un correo electrónico utilizando dos métodos.
* Inserción dinámica a través de javascript. Sobreescritura utilizando PHP.
*/
function enmascarar_correo($correo_plano){
	// Array del correo electrónico
	$array = str_split($correo_plano);
	$id = 'mask_';
	$usuario_correo = '';
	$dominio_correo = '';
	$dominio = false;
	//Por cada caracter se solicita el valor ascii.
	// los valores ascii va a ser dividido entre el usuario y el dominio
	foreach ($array as $char) {
		$id = $id.ord($char);

		if($char === '@'){
				$dominio = true;
		}
		if($dominio === false){
				$usuario_correo = $usuario_correo.'&#'.ord($char).';';
		}else{
			  $dominio_correo = $dominio_correo.'&#'.ord($char).';';
		}

	}

	// Se imprime un div
	return pintar_correo_enmascarado($id, $usuario_correo, $dominio_correo);


}

function pintar_correo_enmascarado($id_div, $usuario_correo, $dominio_correo){
	$inicio_script = '<script>';
	$elemento_js = "var elemento = document.getElementById('".$id_div."');";
	$reiniciar_js = "elemento.innerHTML='';";
	$correo = 'var correo = "'.$dominio_correo.'";';
	$modificar_js = "elemento.innerHTML='".$usuario_correo."'+correo;";
	$fin_script = '</script>';

	$div =  '<span id='.$id_div.'></span>';
	return $div . $inicio_script . $elemento_js . $reiniciar_js . $correo . $modificar_js . $fin_script;

}

?>
