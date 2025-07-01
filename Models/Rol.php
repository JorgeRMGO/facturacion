<?php 
require "../Config/Conexion.php";
require_once "ActivityLog.php"; 
require_once "../Controllers/token.php"; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Rol {
    public function __construct() {
    }
    
    public function store($name) {
        $name = limpiarCadena($name);
        $sql = "INSERT INTO `roles`(`name`, `guard_name`, `created_at`, `updated_at`) VALUES ('$name','web',NOW(),NOW())";
        return ejecutarConsulta($sql);
    }
    
    public function update($registro_id, $name) {
        $name = limpiarCadena($name);
        $sql = "UPDATE `roles` SET `name`='$name', `updated_at`=NOW() WHERE `id`=$registro_id";
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
}   
?>