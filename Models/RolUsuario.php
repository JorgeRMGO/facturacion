<?php 
require "../config/Conexion.php";

class Rol {
    public function __construct() {
    }
    
    public function store($name) {
        $sql = "INSERT INTO `roles`(`name`, `guard_name`, `created_at`, `updated_at`) VALUES ('$name','web',NOW(),NOW())";
        //echo $sql."\n";
        if(ejecutarConsulta($sql)) {
            return ejecutarConsulta("SELECT LAST_INSERT_ID()")->fetch_row()[0];
        }
        return false;
    }
    
    public function update($registro_id, $name) {
        $sql = "UPDATE `roles` SET `name`='$name', `updated_at`=NOW() WHERE `id`=$registro_id";
        return ejecutarConsulta($sql);
    }
    
    public function verificarPermisoVista($role_id, $view_id) {
        $sql = "SELECT COUNT(*) as existe FROM system_views_roles WHERE role_id = $role_id AND view_id = $view_id";
        $result = ejecutarConsultaSimpleFila($sql);
        return $result['existe'] > 0;
    }
    
    public function actualizarPermisosVista($role_id, $view_id, $permisos) {
        $sql = "UPDATE system_views_roles SET 
                permison_create = {$permisos['create']},
                permison_update = {$permisos['update']},
                permison_delete = {$permisos['delete']},
                permison_approve = {$permisos['approve']},
                permison_validate = {$permisos['validate']},
                updated_at = NOW()
                WHERE role_id = $role_id AND view_id = $view_id";
        //echo $sql."\n";
        //return true;
        return ejecutarConsulta($sql);
        
    }
    
    public function crearPermisosVista($role_id, $view_id, $permisos) {
        $sql = "INSERT INTO system_views_roles 
                (role_id, view_id, permison_create, permison_update, permison_delete, permison_approve, permison_validate, created_at, updated_at)
                VALUES ($role_id, $view_id, {$permisos['create']}, {$permisos['update']}, {$permisos['delete']}, {$permisos['approve']}, {$permisos['validate']}, NOW(), NOW())";
        //echo $sql."\n";
        //return true;
        return ejecutarConsulta($sql);
    }
    
    public function index() {
        $sql = "SELECT * FROM `roles`";
        return ejecutarConsulta($sql);
    }
    
    public function show($registro_id) {
        $sql = "SELECT * FROM `roles` WHERE id = '$registro_id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    public function delete($registro_id) {
        //$sql = "SELECT * FROM `roles` WHERE id = '$registro_id'";
        //$resultado = ejecutarConsultaSimpleFila($sql);
        
        $sql = "DELETE FROM `roles` WHERE `id`=$registro_id";
        $resultado = ejecutarConsulta($sql);
        
        $sql = "DELETE FROM system_views_roles
                WHERE role_id = $registro_id";
        ejecutarConsulta($sql);
        
        return $resultado;
    }
    
    public function consultar_vistas() {
        $sql = "SELECT id FROM system_views";
        return ejecutarConsulta($sql);
    }
}
?>