<?php
// Evitar cualquier salida no deseada
ob_start();
require_once "../Models/Login.php";

// Establecer encabezado JSON
header("Content-Type: application/json; charset=UTF-8");

$login = new Login();
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Habilitar reporte de errores para depuración (temporalmente)
ini_set('display_errors', 0);
error_reporting(E_ALL);

switch ($_GET["op"]) {
    case 'validar':
        $tiempo_sesion = 60 * 60 * 24;
        ini_set('session.gc_maxlifetime', $tiempo_sesion);
        ini_set('session.cookie_lifetime', $tiempo_sesion);
        session_set_cookie_params($tiempo_sesion);
        session_start();

        $rspta = $login->validar($usuario, $password);

        if ($rspta !== 404) {
            if (password_verify($password, $rspta['password'])) {
                $_SESSION['usuario_id'] = $rspta['id'];
                $_SESSION['usuario'] = $rspta['username'];
                $_SESSION['nombre_usuario'] = $rspta['name'];
                $_SESSION['id_empleado'] = $rspta['id_empleado'];
                $_SESSION['empleado'] = $rspta['empleado'];
                $_SESSION['id_planta'] = $rspta['branch_office_id'];
                $_SESSION['rol'] = $rspta['rol'];

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Inicio de sesión exitoso',
                    'code' => 200
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuario o contraseña incorrectos',
                    'code' => 401
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario o contraseña incorrectos',
                'code' => 404
            ]);
        }
        break;

    case 'salir':
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header("Location: ../Views/login.php");
        exit;
        break;

    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Operación no válida',
            'code' => 400
        ]);
        break;
}

// Limpiar cualquier salida previa
ob_end_flush();
?>