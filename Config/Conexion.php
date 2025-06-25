<?php 
require_once "global.php";
require_once "ConexionTunel.php";

$conexiontunel = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conexiontunel->connect_error) {
    die(" Conexión por túnel fallida: " . $conexiontunel->connect_error);
}




mysqli_query($conexion, 'SET NAMES "' . DB_ENCODE . '"');

if (mysqli_connect_errno()) {
    printf("❌ Error en la conexión normal: %s\n", mysqli_connect_error());
    exit();
}

if (!function_exists('ejecutarConsulta')) {

	function ejecutarConsulta($sql){ 
		global $conexion;
		return $conexion->query($sql);
	} 

	function ejecutarConsultaSimpleFila($sql){
		global $conexion;
		$query = $conexion->query($sql);
		return $query->fetch_assoc();
	}

	function ejecutarConsulta_retornarID($sql){
		global $conexion;
		$conexion->query($sql);
		return $conexion->insert_id;
	}

	function limpiarCadena($str){
		global $conexion;
		return htmlspecialchars(mysqli_real_escape_string($conexion, trim($str)));
	}

	function limpiarJSON($str){
		global $conexion;
		return mysqli_real_escape_string($conexion, trim($str));
	}
}
?>
