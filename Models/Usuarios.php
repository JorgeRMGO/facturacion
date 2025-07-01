<?php 
require "../config/Conexion.php";

class CreateUser {
    private $conn;
    
    public function __construct() {
        global $conexion;
        $this->conn = $conexion;
    }
    
    // Validar usuario y contraseña (en tabla users)
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

    // Obtener todos los usuarios con sus roles (desde tabla users)
    public function getAllUsers() {
        $sql = "SELECT users.id, users.username, users.email, roles.name AS rol
                FROM users
                INNER JOIN model_has_roles ON model_has_roles.model_id = users.id
                INNER JOIN roles ON roles.id = model_has_roles.role_id";

        $result = $this->conn->query($sql);
        if(!$result) {
            error_log("Error en consulta getAllUsers: " . $this->conn->error);
            return [];
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // Crear usuario (tabla employees)
    public function createUser($nombre, $clave_empleado, $email, $password) {
        // Encripta la contraseña antes de guardar
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO employees (full_name, code, email, password) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Error preparando createUser: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("siss", $nombre, $clave_empleado, $email, $password_hash);

        if (!$stmt->execute()) {
            error_log("Error ejecutando createUser: " . $stmt->error);
            return false;
        }

        return true;
    }

    // Obtener usuario por ID (tabla employees)
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM employees WHERE id = ?");
        if (!$stmt) {
            error_log("Error preparando getUserById: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Error ejecutando getUserById: " . $stmt->error);
            return null;
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Actualizar usuario (tabla employees)
    public function updateUser($id, $nombre, $clave_empleado, $email) {
        $stmt = $this->conn->prepare("UPDATE employees SET full_name = ?, employee_code = ?, email = ? WHERE id = ?");
        if (!$stmt) {
            error_log("Error preparando updateUser: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("sisi", $nombre, $clave_empleado, $email, $id);
        if (!$stmt->execute()) {
            error_log("Error ejecutando updateUser: " . $stmt->error);
            return false;
        }

        return true;
    }

    // Eliminar usuario (tabla employees)
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM employees WHERE id = ?");
        if (!$stmt) {
            error_log("Error preparando deleteUser: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Error ejecutando deleteUser: " . $stmt->error);
            return false;
        }

        return true;
    }
}
?>
