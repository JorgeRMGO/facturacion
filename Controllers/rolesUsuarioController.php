<?php

require_once 'token.php';
require_once '../Models/RolUsuario.php';

$usuario = protegerRuta();
$rol = new Rol();
$registro_id = $_POST['id_registro'] ?? null;
$name = $_POST['name']?? null;
$permisos = $_POST['permisos']?? [];


switch($_GET["op"]){
    case 'store':
        if($registro_id){
            $rspta = $rol->update($registro_id,$name);
        } else {
            $rspsta = $rol->store($name);
        }
        echo $rpsta;
        break;
        
case 'update_with_permissions':
    //Si es nuevo rol (id=0), primero lo creamos
    if($registro_id == 0){
        $registro_id = $rol->store($name);
        //echo $registro_id;
        if(!$registro_id){
            echo "Error al crear el rol";
            exit;
        }
    } else{
        //Si es edicion, actualizamos el nombre
        $rspta = $rol->update($registro_id, $name);
    }
        //Solo procesamos permisos si el rol ya existe(id > 0)
        if($registro_id > 0 ){
            //Obtener todas las vistas para asegurarnos de procesarlas todas
            $vistas = $rol->consultar_vistas();
            
            while($vista = mysqli_fetch_array($vistas)){
                $view_id = $vista['id'];
                $existe = $rol->verificarPermisoVista($registro_id,$view_id);
                //Determina si solo es vista 
                $soloVista = isset($_POST['solo_vista'][$view_id]) && $_POST['solo_vista'][$view_id] === 'on';
                //echo $soloVista
                if($soloVista){
                    $data_permisos = [
                        'create' => 0,
                        'update' => 0,
                        'delete' => 0,
                        'approve' => 0,
                        'validate' => 0,
                    ];
                }
                else{
                    $data_permisos = [
                        'create' => isset($permisos[$view_id]['create']) ? 1 : 0,
                        'update' => isset($permisos[$view_id]['update']) ? 1 : 0,
                        'delete' => isset($permisos[$view_id]['delete']) ? 1 : 0,
                        'approve' => isset($permisos[$view_id]['approve']) ? 1 : 0,
                        'validate' => isset($permisos[$view_id]['validate']) ? 1 : 0,
                    ];
                }
                
                if($existe){
                    $rol->actualizarPermisoVista($registro_id,$view_id,$data_permisos);
                }else{
                    //solo crear registro si hay permisos o solo es vista
                    if($soloVista || !empty(array_filter($data_permisos))){
                        $rol->crearPermisoVista($registro_id,$view_id,$data_permisos);
                    }
                }
            }
        }
        
        echo $registro_id;
        break;
    
    case 'show':
    $rspta = $rol->index();
    $data = Array();
    while($reg = $rspta->fetch_object()){
        $bonton_editar = '<button type="button" class="editar btn btn-sm btn-warning" onclick="show('.$reg->id.')"><i class="ti ti-edit"></i></button>';
        $bonton_borrar = '<button type="button" class="borrar btn btn-sm btn-danger" onclick="borrar('.$reg->id.')"><i class="ti ti-trash"></i></button>';
        
        $data[] = array(
            "0" => $bonton_editar.' '.$bonton_borrar,
            "1" => $reg-> id,
            "2" => $reg->name
        );
    }

    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
    break;

    case 'delete':
    $rspta = $rol->delete($registro_id);
    echo json_encode($rspta);
    break;

    }                    
?>