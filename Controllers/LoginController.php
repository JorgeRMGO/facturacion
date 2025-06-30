<?php
ob_start();
require_once "../Models/Login.php";
require_once "../Controllers/token.php"; // Asegúrate de que esta ruta sea válida

$jwt_secret = "Mx2111or71zG0";

// Se establece el encabezado de tipo de contenido JSON al inicio, ya que todas las respuestas de este controlador serán JSON.
header("Content-Type: application/json; charset=UTF-8");

$login = new Login();
$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

switch ($_GET["op"]) {

    case 'validar':
        // Configuración de la sesión
        $tiempo_sesion = 60 * 60 * 24; // 24 horas
        ini_set('session.gc_maxlifetime', $tiempo_sesion);
        ini_set('session.cookie_lifetime', $tiempo_sesion);
        session_set_cookie_params($tiempo_sesion);
        session_start();

        $rspta = $login->validar($usuario, $password);

        if ($rspta !== 404) {
            if (password_verify($password, $rspta['password'])) {
                // Configurar variables de sesión
                $_SESSION['usuario_id'] = $rspta['id'];
                $_SESSION['username'] = $rspta['username'];
                $_SESSION['empleado'] = $rspta['empleado']; // Este es el nombre del empleado/usuario si viene de la DB
                $_SESSION['rol'] = $rspta['rol'];
                $_SESSION['id_empleado'] = $rspta['id_empleado'];
                $_SESSION['id_planta'] = $rspta['branch_office_id'];
                $_SESSION['nombre_completo'] = $rspta['name']; // <--- ¡Línea agregada para el nombre completo!
                
                // Datos para el token JWT
                $userDataForToken = [
                    'id' => $rspta['id'],
                    'username' => $rspta['username'],
                    'nombre_usuario' => $rspta['name'], // Usando 'name' para el nombre completo en el token
                    'id_empleado' => $rspta['id_empleado'],
                    'empleado' => $rspta['empleado'],
                    'id_planta' => $rspta['branch_office_id'],
                    'rol' => $rspta['rol']
                ];

                // Generar el token JWT
                $jwt = generarToken($userDataForToken, $jwt_secret);

                // Respuesta JSON de éxito
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Inicio de sesión exitoso',
                    'code' => 200,
                    'token' => $jwt,
                    'user' => [
                        'username' => $rspta['username'],
                        'nombre' => $rspta['name'], // También envías el nombre en la respuesta JSON
                        'rol' => $rspta['rol']
                    ]
                ]);
            } else {
                // Contraseña incorrecta
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuario o contraseña incorrectos',
                    'code' => 401
                ]);
            }
        } else {
            // Usuario no encontrado (404 de la validación del modelo)
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario o contraseña incorrectos',
                'code' => 404
            ]);
        }
        break;

    case 'someProtectedAction':
        // Esta función 'protegerRuta()' debería verificar la validez del JWT
        // presente en el encabezado 'Authorization' de la petición.
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
        $_SESSION = array(); // Vacía todas las variables de sesión
        
        // Si se usan cookies de sesión, invalidarlas
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000, // Hace que la cookie expire inmediatamente
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy(); // Destruye la sesión en el servidor

        // Redirige a la vista de login.
        header("Location: ../Views/login.php");
        exit;
        break;

    default:
        // Caso por defecto para operaciones no válidas
        echo json_encode([
            'status' => 'error',
            'message' => 'Operación no válida',
            'code' => 400
        ]);
        break;
}

ob_end_flush();
?>