<?php
$directorio = __DIR__ . "/"; // porque ya estás en online_users/
$archivos = glob($directorio . "online_*.json");

$usuarios_en_linea = 0;
$ahora = time();
$tiempo_limite = 300; // 5 minutos

foreach ($archivos as $archivo) {
    $contenido = json_decode(file_get_contents($archivo), true);
    if (isset($contenido['timestamp']) && ($ahora - $contenido['timestamp']) <= $tiempo_limite) {
        $usuarios_en_linea++;
    } else {
        unlink($archivo);
    }
}

echo $usuarios_en_linea;
?>
