<?php
// Controllers/token.php

require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
//use Exception;

$jwt_secret = "Mx2111or71zG0";

function protegerRuta() {
    global $jwt_secret;

    // --- CAMBIO AQUÍ: Forma más robusta de obtener el encabezado Authorization ---
    $authHeader = '';
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $authHeader = $requestHeaders['Authorization'] ?? $requestHeaders['authorization'] ?? '';
    } else {
        // Fallback para otros entornos, aunque menos común para Authorization
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    }
    // --- FIN DEL CAMBIO ---


    if (!$authHeader) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado", "code" => 401]);
        exit();
    }

    list($jwt) = sscanf($authHeader, 'Bearer %s');

    if (!$jwt) {
        http_response_code(401);
        echo json_encode(["error" => "Formato de token inválido. Se esperaba 'Bearer <token>'", "code" => 401]);
        exit();
    }

    try {
        $decoded = JWT::decode($jwt, new Key($jwt_secret, 'HS256'));
        return (array)$decoded->data;
    } catch (ExpiredException $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token expirado", "code" => 401]);
        exit();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(["error" => "Token inválido", "code" => 403]);
        exit();
    }
}

function generarToken($user_data, $jwt_secret) {
    $expiration_time = time() + (60 * 60 * 24);

    $payload = [
        'iss' => 'http://tu-app.com',
        'aud' => 'http://tu-app.com',
        'iat' => time(),
        'exp' => $expiration_time,
        'data' => $user_data
    ];

    return JWT::encode($payload, $jwt_secret, 'HS256');
}