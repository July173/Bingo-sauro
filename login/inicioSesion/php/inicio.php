<?php
    session_start();
    require '../../../conexion_BD/conexion.php';
    class inicio{
        private $conexion;
        private $pdo;
        public function __construct(){
            try {
                $this->conexion = new conexion();
                $this->pdo = $this->conexion->conectar();
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        public function validarCredenciales($correo, $contrasena) {
            try {
                if (empty($correo) || empty($contrasena)) {
                    error_log("Datos vacíos recibidos en validarCredenciales");
                    return ['validas' => false, 'mensaje' => 'Datos incompletos'];
                }

                error_log("Validando credenciales para correo: " . $correo);
                
                $query = "SELECT * FROM usuario WHERE correo = :correo LIMIT 1";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':correo', $correo);
                $stmt->execute();
                
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$usuario) {
                    error_log("Usuario no encontrado: " . $correo);
                    return ['validas' => false, 'mensaje' => 'Usuario no encontrado'];
                }
                
                // Verificar la contraseña
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['correo'] = $usuario['correo'];
                    return ['validas' => true, 'mensaje' => 'Login exitoso'];
                }
                
                return ['validas' => false, 'mensaje' => 'Contraseña incorrecta'];
                
            } catch (PDOException $e) {
                error_log("Error en BD: " . $e->getMessage());
                return ['validas' => false, 'mensaje' => 'Error en la base de datos'];
            }
        }

    }
?>