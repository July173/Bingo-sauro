<?php
header('Content-Type: application/json'); // Asegurarnos de que la respuesta sea JSON
require '../../../conexion_BD/conexion.php';

class registrar {
    private $pdo;
    private $response;

    public function __construct() {
        $this->pdo = new Conexion();
        $this->response = ['success' => false, 'errors' => []];
    }

    public function registrarUsuario($datos) {
        try {
            // Validar que el correo no exista
            $stmt = $this->pdo->conectar()->prepare("SELECT COUNT(*) FROM usuario WHERE correo = ?");
            $stmt->execute([$datos['email']]);
            if ($stmt->fetchColumn() > 0) {
                $this->response['errors'][] = "El correo ya está registrado";
                return $this->response;
            }

            // Generar token de verificación
            $token = bin2hex(random_bytes(32));
            
            // Para debug - agregar estos logs
            error_log("Token generado: " . $token);
            error_log("Email: " . $datos['email']);

            // Hashear la contraseña
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);

            // Insertar usuario con el token
            $query = "INSERT INTO usuario (primer_nombre, correo, contrasena, token_verificacion, verificado) 
                     VALUES (?, ?, ?, ?, FALSE)";
            $params = [$datos['primer_nombre'], $datos['email'], $passwordHash, $token];
            
            // Para debug
            error_log("Query: " . $query);
            error_log("Params: " . print_r($params, true));

            $this->pdo->insert($query, $params);

            // Enviar correo
            require_once(__DIR__ . '/../../mailer/mailer.php');
            enviarCorreoBienvenida($datos['email'], $datos['primer_nombre'], $token);

            $this->response['success'] = true;
            $this->response['message'] = "Por favor, verifica tu correo para completar el registro";
        } catch (Exception $e) {
            error_log("Error en registro: " . $e->getMessage());
            $this->response['errors'][] = "Error: " . $e->getMessage();
        }
        return $this->response;
    }
}

// Procesar la petición AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = json_decode(file_get_contents('php://input'), true);
    $registro = new registrar();
    $resultado = $registro->registrarUsuario($datos);
    
    echo json_encode($resultado);
    exit;
}
?>