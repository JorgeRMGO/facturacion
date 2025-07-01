<?php 

require_once "../Models/RolUsuario.php";

$rol = new Rol();
$registro_id = $_POST['id_registro'] ?? null;
$name = $_POST['name'] ?? null;
$permisos = $_POST['permisos'] ?? [];

switch ($_GET["op"]) {
    case 'store':
        if ($registro_id) {
            $rspta = $rol->update($registro_id, $name);
        } else {
            $rspta = $rol->store($name);
        }
        echo json_encode(["success" => true, "message" => "Rol guardado correctamente", "id" => $rspta]);
        break;

    case 'update_with_permissions':
        if ($registro_id == 0) {
            $registro_id = $rol->store($name);
            if (!$registro_id) {
                echo json_encode(["success" => false, "message" => "Error al crear el rol"]);
                exit;
            }
        } else {
            $rol->update($registro_id, $name);
        }

        if ($registro_id > 0) {
            $vistas = $rol->consultar_vistas();

            while ($vista = mysqli_fetch_array($vistas)) {
                $view_id = $vista['id'];
                $existe = $rol->verificarPermisoVista($registro_id, $view_id);

                $soloVista = isset($_POST['solo_vista'][$view_id]) && $_POST['solo_vista'][$view_id] == 'on';

                if ($soloVista) {
                    $data_permisos = [
                        'create' => 0,
                        'update' => 0,
                        'delete' => 0,
                        'approve' => 0,
                        'validate' => 0
                    ];
                } else {
                    $data_permisos = [
                        'create'   => isset($permisos[$view_id]['create']) ? 1 : 0,
                        'update'   => isset($permisos[$view_id]['update']) ? 1 : 0,
                        'delete'   => isset($permisos[$view_id]['delete']) ? 1 : 0,
                        'approve'  => isset($permisos[$view_id]['approve']) ? 1 : 0,
                        'validate' => isset($permisos[$view_id]['validate']) ? 1 : 0
                    ];
                }

                if ($existe) {
                    $rol->actualizarPermisosVista($registro_id, $view_id, $data_permisos);
                } else {
                    if ($soloVista || !empty(array_filter($data_permisos))) {
                        $rol->crearPermisosVista($registro_id, $view_id, $data_permisos);
                    }
                }
            }
        }

        echo json_encode(["success" => true, "message" => "Rol actualizado", "id" => $registro_id]);
        break;

    case 'show':
        $rspta = $rol->show($registro_id);
        echo json_encode($rspta);
        break;

    case 'index':
        $rspta = $rol->index();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $acciones = '
                <button type="button" class="btn btn-sm btn-primary" onclick="show('.$reg->id.')">Editar</button>
                <button type="button" class="btn btn-sm btn-danger" onclick="borrar('.$reg->id.')">Eliminar</button>
            ';
            $data[] = array(
                "acciones"   => $acciones,
                "role_id"    => $reg->id,
                "role_name"  => $reg->name
            );
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'delete':
        $rspta = $rol->delete($registro_id);
        echo json_encode([
            "success" => $rspta ? true : false,
            "message" => $rspta ? "Rol eliminado correctamente" : "No se pudo eliminar el rol"
        ]);
        break;
}
