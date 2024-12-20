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
                
                error_log("Datos del usuario de la BD: " . print_r($usuario, true));
                
                if (!$usuario) {
                    error_log("Usuario no encontrado: " . $correo);
                    return ['validas' => false, 'mensaje' => 'Usuario no encontrado'];
                }
                
                // Verificar si el usuario está verificado
                if (!$usuario['verificado']) {
                    error_log("Usuario no verificado: " . $correo);
                    return [
                        'validas' => false, 
                        'mensaje' => 'USUARIO_NO_VERIFICADO',
                        'descripcion' => 'Tu cuenta no está verificada. Por favor, revisa tu correo electrónico y sigue el enlace de verificación.'
                    ];
                }
                
                // Verificar la contraseña
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    $_SESSION['usuario_id'] = $usuario['id_usuario'];
                    $_SESSION['correo'] = $usuario['correo'];
                    $_SESSION['nombre'] = $usuario['primer_nombre'];
                    
                    error_log("Datos a enviar al cliente: " . json_encode([
                        'nombre' => $usuario['primer_nombre'],
                        'correo' => $usuario['correo']
                    ]));
                    
                    return [
                        'validas' => true, 
                        'mensaje' => 'Login exitoso',
                        'usuario' => [
                            'nombre' => $usuario['primer_nombre'],
                            'correo' => $usuario['correo'],
                            'usuario_id' => $usuario['id_usuario']
                        ]
                    ];
                } else {
                    error_log("Contraseña incorrecta para el usuario: " . $correo);
                    return ['validas' => false, 'mensaje' => 'Contraseña incorrecta'];
                }
        
            } catch (PDOException $e) {
                error_log("Error en BD: " . $e->getMessage());
                return ['validas' => false, 'mensaje' => 'Error en la base de datos'];
            }
        }

    }