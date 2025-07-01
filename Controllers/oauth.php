<?php
require_once(__DIR__ . '/../vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "Mx2111or71zG0";

function validarJWT() {
    global $key;
    session_start();

    $jwt = $_SESSION['jwt_token'] ?? $_COOKIE['jwt_token'] ?? null;

    if (!$jwt) {
        redirigirLogin("sin_token");
    }

    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return (array)$decoded->data;
    } catch (\Firebase\JWT\ExpiredException $e) {
        redirigirLogin("token_expired");
    } catch (Exception $e) {
        redirigirLogin("invalid_token");
    }
}

function redirigirLogin($error) {
    session_destroy();
    setcookie("jwt_token", "", time() - 3600, "/");
    header("Location: login.php?error=$error");
    exit();
}
