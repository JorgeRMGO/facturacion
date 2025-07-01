<?php
require_once '../Models/Usuarios.php';

$usuario = new CreateUser();

switch ($_GET['op']) {
    case 'listar':
        $data = $usuario->getAllUsers();

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
        break;
        case 'crear':
        $result = $usuario->createUser($_POST['name'], $_POST['username'], $_POST['employee_code'], $_POST['email'], $_POST['password']);
        echo json_encode(["success" => $result]);
        break;

    case 'obtener':
        $user = $usuario->getUserById($_GET['id']);
        echo json_encode($user);
        break;

    case 'editar':
        $result = $usuario->updateUser($_POST['id'], $_POST['name'], $_POST['username'], $_POST['employee_code'], $_POST['email']);
        echo json_encode(["success" => $result]);
        break;

    case 'eliminar':
        $result = $usuario->deleteUser($_POST['id']);
        echo json_encode(["success" => $result]);
        break;


}
?>
