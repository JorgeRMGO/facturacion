<?php 
require "../config/Conexion.php";

class Login {
    private $conn;
    
    public function __construct() {
    global $conexion;
    $this->conn = $conexion;
    }
    
    public function validar($usuario, $password) {
        $sql = "SELECT users.*, 
                       employees.id AS id_empleado, 
                       employees.full_name AS empleado, 
                       employees.branch_office_id, 
                       roles.name AS rol
                FROM users
                LEFT JOIN employees ON employees.user_id = users.id
                INNER JOIN model_has_roles ON model_has_roles.model_id = users.id
                INNER JOIN roles ON roles.id = model_has_roles.role_id
                WHERE users.username = ? OR users.email = ?";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error preparando la consulta: " . $this->conn->error);
            return 404;
        }
        
        $stmt->bind_param("ss", $usuario, $usuario);
        if (!$stmt->execute()) {
            error_log("Error ejecutando la consulta: " . $stmt->error);
            return 404;
        }
        
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $mostrar = $result->fetch_assoc();
            if (password_verify($password, $mostrar['password'])) {
                return $mostrar;
            } else {
                return 404;
            }
        } else {
            return 404;
        }
    }
}
?>