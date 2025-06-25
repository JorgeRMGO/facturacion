<?php 
require_once "../Models/Login.php";
require_once('../Models/NetSuiteRestService.php');


$login = new Login();
$usuario = $_POST['usuario'];
$password = $_POST['password'];


switch ($_GET["op"]) {
    // case 'validar':
    //     session_start();
    //     $rspta = $login->validar( $usuario, $password );
    //     echo json_encode($rspta);
    
    // break;
    
    case 'validar':
        
        $tiempo_sesion = 60 * 60 * 24; // 24 horas
        ini_set('session.gc_maxlifetime', $tiempo_sesion);
        ini_set('session.cookie_lifetime', $tiempo_sesion);
        session_set_cookie_params($tiempo_sesion);
        session_start();
    
        $rspta = $login->validar($usuario, $password);
    
        if ($rspta !== 404) {
            $_SESSION['usuario_id'] = $rspta['id'];
            $_SESSION['usuario'] = $rspta['username'];
            $_SESSION['nombre_usuario'] = $rspta['name'];
            $_SESSION['planta'] = $rspta['current_branch_office_id'];
            $_SESSION['id_empleado'] = $rspta['id_empleado'];
            $_SESSION['nombre_empleado'] = $rspta['nombre_empleado'];
            $_SESSION['id_planta'] = $rspta['branch_office_id'];
            $_SESSION['rol'] = $rspta['rol'];
    
            echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso', 'code'=>200]);
        } else {
            // Devolver una respuesta de error
            echo json_encode(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos', 'code'=>404]);
        }

    break;

    
    case 'salir':  
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: ../Views/login.php");
 



        
        
        
	break;

}
?>