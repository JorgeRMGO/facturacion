<?php 
require_once "global.php";

$conexion=new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

//muestra posible error en la conexion
if (mysqli_connect_errno()) {
	printf("Ups parece que falló en la conexion con la base de datos: %s\n",mysqli_connect_error());
	exit();
}

if (!function_exists('ejecutarConsulta')) {
	Function ejecutarConsulta($sql){ 
		global $conexion;
		$query=$conexion->query($sql);
		return $query;
	//verificar si consulta fallo
	if($query){
		echo "Error en la consulta". $conexion->error;
		return false;

		}
		return $query;
	} 

	function ejecutarConsultaSimpleFila($sql){
		global $conexion;

		$query=$conexion->query($sql);
		$row=$query->fetch_assoc();
		return $row;
	}
	function ejecutarConsulta_retornarID($sql){
		global $conexion;
		$query=$conexion->query($sql);
		return $conexion->insert_id;
	}

	function limpiarCadena($str){
		global $conexion;
		$str=mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}
	
	function limpiarJSON($str){
    	global $conexion;
    	return mysqli_real_escape_string($conexion, trim($str));
    }
	

}

?>