<?php 
    require "../config/Conexion.php";
    
    class Login {

        private $conn;
        
        public function __construct() {
            global $conn;
            $this->conn = $conn;
        }
        
        
	   // public function validar( $usuario, $password ){
	   //     $sql="SELECT * FROM `users` WHERE username='$usuario'";
	   //     $result = ejecutarConsulta($sql);
	        
	   //     if($result){
	   //         while($mostrar=mysqli_fetch_array($result)){
    //                 $password_db=$mostrar['password'];
    //             }
    // 	        if (password_verify('password', $password_db)) {
    //                 return ejecutarConsulta($sql);
    //             } else {
    //                 return 404;
    //             }
	   //     }else{
	   //         return 404;
	   //     }
	        
	       
	   // }
	   
	   
	   public function validar($usuario, $password) {
	       
	   $sql="SELECT users.*, 
                   employees.id AS id_empleado, 
                   employees.full_name AS nombre_empleado, 
                   employees.branch_office_id, 
                   roles.name AS rol
            FROM users
            LEFT JOIN employees ON employees.user_id = users.id
            INNER JOIN model_has_roles ON model_has_roles.model_id = users.id
            INNER JOIN roles ON roles.id = model_has_roles.role_id
            WHERE users.username = '$usuario' OR users.email ='$usuario' ";    
	   
        // $sql = "SELECT users.*, employees.id AS id_empleado, employees.full_name AS nombre_operador, employees.branch_office_id, roles.name AS rol
        //         FROM `users` 
        //         LEFT JOIN employees ON employees.user_id= users.id
        //         INNER JOIN model_has_roles ON model_has_roles.model_id
        //         INNER JOIN roles ON roles.id = model_has_roles.role_id
        //         WHERE users.username = '$usuario' OR users.email ='$usuario' ";
        $result = ejecutarConsulta($sql);
        
        if ($result && mysqli_num_rows($result) > 0) {

            $mostrar = mysqli_fetch_array($result);
            $password_db = $mostrar['password'];
            
            if($password_db){
            // if (password_verify($password, $password_db)) {

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
    
    
    
    
    
    
    