<?php 

require_once "token.php";
require_once "../Models/Rol.php";

$usuario = protegerRuta();
$rol = new Rol();
$registro_id = isset($_POST['id_registro']) ? (int)$_POST['id_registro'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';

switch ($_GET["op"]) {
    case 'store':
        if ($registro_id) {
            $rspta = $rol->update($registro_id, $name);
            $message = 'Rol actualizado';
        } else {
            $rspta = $rol->store($name);
            $message = 'Rol creado';
        }
        echo json_encode(['success' => $rspta, 'message' => $message]);
        break;
    
    case 'update':
        $rspta = $rol->update($registro_id, $name);
        echo json_encode(['success' => $rspta, 'message' => 'Rol actualizado']);
        break;
    
    case 'show':
    $rspta = $rol->show($registro_id);
    if ($rspta && isset($rspta['name'])) {
        echo json_encode($rspta);
    } else {
        echo json_encode(['success' => false, 'message' => 'Rol no encontrado']);
    }
    break;
    
    case 'index':
        $rspta = $rol->index();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $bonton_editar = '<button type="button" class="btn btn-sm btn-warning" onclick="show('.$reg->id.')"><i class="ti ti-edit"></i></button>';
            $bonton_borrar = '<button type="button" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>';
            $data[] = [
                "0" => $bonton_editar . ' ' . $bonton_borrar,
                "1" => $reg->id,
                "2" => $reg->name,
            ];
        }
        $results = [
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ];
        echo json_encode($results);
        break;
    
    case 'update_with_permissions':
        $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];
        $solo_vista = isset($_POST['solo_vista']) ? $_POST['solo_vista'] : [];

        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'El nombre del rol es requerido']);
            exit;
        }

        // Crear o actualizar el rol
        if ($registro_id == 0) {
            $rspta = $rol->store($name);
            $registro_id = ejecutarConsulta_retornarID("SELECT LAST_INSERT_ID() as id");
            $message = 'Rol creado correctamente';
        } else {
            $rspta = $rol->update($registro_id, $name);
            $message = 'Rol actualizado correctamente';
        }

        if ($rspta) {
            // Eliminar permisos existentes
            $sql_delete = "DELETE FROM system_views_roles WHERE role_id = $registro_id";
            ejecutarConsulta($sql_delete);

            // Insertar nuevos permisos
            foreach ($permisos as $view_id => $permiso) {
                $create = isset($permiso['create']) ? 1 : 0;
                $update = isset($permiso['update']) ? 1 : 0;
                $delete = isset($permiso['delete']) ? 1 : 0;
                $approve = isset($permiso['approve']) ? 1 : 0;
                $validate = isset($permiso['validate']) ? 1 : 0;
                $is_solo_vista = isset($solo_vista[$view_id]) ? 1 : 0;

                if ($is_solo_vista) {
                    $create = $update = $delete = $approve = $validate = 0;
                }

                $sql_permiso = "INSERT INTO system_views_roles (role_id, view_id, permison_create, permison_update, permison_delete, permison_approve, permison_validate, created_at, updated_at) 
                                VALUES ($registro_id, $view_id, $create, $update, $delete, $approve, $validate, NOW(), NOW())";
                ejecutarConsulta($sql_permiso);
            }

            echo json_encode(['success' => true, 'message' => $message, 'id' => $registro_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el rol']);
        }
        break;
}
?>