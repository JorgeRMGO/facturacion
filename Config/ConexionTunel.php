<?php
$host = "127.0.0.1";   // Usas 127.0.0.1 si estás en el mismo server o usas túnel
$puerto = 3306;        // O 3307 si estás usando un túnel SSH en ese puerto
$usuario = "jorge";     // Cambia por tu user de la base
$contrasena = "hh2a0kngyo7epjboc9rl";  // Tu contraseña
$basedatos = "employees";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "🔥 Conectado con éxito a la base de datos";
?>
