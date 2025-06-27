<?php
session_start();
if (!isset($_SESSION['usuario_id'])) exit;

// Aquí solo ponemos __DIR__ porque ya estamos en online_users
$archivo = __DIR__ . "/online_{$_SESSION['usuario_id']}.json";

file_put_contents($archivo, json_encode([
    'usuario_id' => $_SESSION['usuario_id'],
    'nombre' => $_SESSION['empleado'],
    'timestamp' => time()
]));

echo "ok";
?>
