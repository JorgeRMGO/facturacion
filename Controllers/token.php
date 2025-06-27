<?php 

$key = "Mx2111or71zG0";

function protegerRuta() {
    global $key;

    // Obtener el token del encabezado Authorization
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';

    if (!$authHeader) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado"]);
        exit();
    }

    // Extraer el token del encabezado
    list($jwt) = sscanf($authHeader, 'Bearer %s');

    if (!$jwt) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado"]);
        exit();
    }

    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return (array)$decoded->data;
    } catch (\Firebase\JWT\ExpiredException $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token expirado"]);
        exit();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(["error" => "Token inválido"]);
        exit();
    }
}
