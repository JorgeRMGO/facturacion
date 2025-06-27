<?php
$host = "127.0.0.1";   
$puerto = 3307;        
$usuario = "hikcentral";     
$contrasena = "5GgAN7m65DRxuFgHMVun";
$basedatos = "employees";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//echo "🔥 Conectado con éxito a la base de datos";
?>
