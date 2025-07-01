<?php 
require_once(__DIR__ . '/../vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "Mx2111or71zG0";

function generarToken($data, $secret) {
    $issuedAt = time();
    $expirationTime = $issuedAt + (60 * 60 * 24); // 24 horas

    $payload = array(
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'data' => $data
    );

    return JWT::encode($payload, $secret, 'HS256');
}

function protegerRuta() {
    global $key;

    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';

    if (!$authHeader) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado"]);
        exit();
    }

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
