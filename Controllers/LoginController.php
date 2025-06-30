<?php
ob_start();
require_once "../Models/Login.php";
require_once "../Controllers/token.php"; // Asegúrate de que esta ruta sea válida

$jwt_secret = "Mx2111or71zG0";

// Solo se usa JSON en caso de login exitoso
$login = new Login();
$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

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

                // ✅ Aquí se setean las variables de sesión
                $_SESSION['usuario_id'] = $rspta['id'];
                $_SESSION['username'] = $rspta['username'];
                $_SESSION['empleado'] = $rspta['empleado'];
                $_SESSION['rol'] = $rspta['rol'];
                $_SESSION['id_empleado'] = $rspta['id_empleado'];
                $_SESSION['id_planta'] = $rspta['branch_office_id'];

                // JWT opcional si usas APIs también
                $userDataForToken = [
                    'id' => $rspta['id'],
                    'username' => $rspta['username'],
                    'nombre_usuario' => $rspta['name'],
                    'id_empleado' => $rspta['id_empleado'],
                    'empleado' => $rspta['empleado'],
                    'id_planta' => $rspta['branch_office_id'],
                    'rol' => $rspta['rol']
                ];

                $jwt = generarToken($userDataForToken, $jwt_secret);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Inicio de sesión exitoso',
                    'code' => 200,
                    'token' => $jwt,
                    'user' => [
                        'username' => $rspta['username'],
                        'nombre' => $rspta['name'],
                        'rol' => $rspta['rol']
                    ]
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

    case 'someProtectedAction':
        $userData = protegerRuta(); 

        echo json_encode([
            'status' => 'success',
            'message' => 'Acceso autorizado a la acción protegida',
            'usuario_del_token' => $userData,
            'recurso_protegido_ejemplo' => 'Aquí va la información o acción que solo usuarios con token pueden ver/hacer.'
        ]);
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
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode([
            'status' => 'error',
            'message' => 'Operación no válida',
            'code' => 400
        ]);
        break;
}

ob_end_flush();
?>
