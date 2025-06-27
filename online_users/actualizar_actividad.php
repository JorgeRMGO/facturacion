<?php
session_start();
if (!isset($_SESSION['usuario_id'])) exit;

$archivo = __DIR__ . "/online_users/online_{$_SESSION['usuario_id']}.json";

file_put_contents($archivo, json_encode([
    'usuario_id' => $_SESSION['usuario_id'],
    'nombre' => $_SESSION['empleado'],
    'timestamp' => time()
]));
?>
