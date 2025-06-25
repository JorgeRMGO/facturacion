<?php
$host = "127.0.0.1";   // Usas 127.0.0.1 si estás en el mismo server o usas túnel
$puerto = 3307;        // O 3307 si estás usando un túnel SSH en ese puerto
$usuario = "hikcentral";     // Cambia por tu user de la base
$contrasena = "5GgAN7m65DRxuFgHMVun";  // Tu contraseña
$basedatos = "employees";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "🔥 Conectado con éxito a la base de datos";
?>
