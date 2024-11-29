<?php
header('Content-Type: application/json'); // Asegurarnos de que la respuesta sea JSON
require '../../../conexion_BD/conexion.php';

class Registrar {
    private $pdo;
    private $response;
    private $urlBase;

    public function __construct() {
        $this->pdo = new Conexion();
        $this->response = ['success' => false, 'errors' => []];
        
        // Definir la URL base para la verificación
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $this->urlBase = $protocol . $host . '/Bingo-sauro/login/verificar.php';
    }

    public function registrarUsuario($datos) {
        try {
            // Añadir log para debugging
            error_log("Iniciando proceso de registro para: " . $datos['email']);
            
            // Validar que el mailer existe antes de continuar
            $mailerPath = __DIR__ . '/../../mailer/mailer.php';
            if (!file_exists($mailerPath)) {
                throw new Exception("Error de configuración: mailer.php no encontrado");
            }
            require_once($mailerPath);

            // Validar que el correo no exista
            $stmt = $this->pdo->conectar()->prepare("SELECT COUNT(*) FROM usuario WHERE correo = ?");
            $stmt->execute([$datos['email']]);
            if ($stmt->fetchColumn() > 0) {
                $this->response['errors'][] = "El correo ya está registrado";
                return $this->response;
            }

            // Generar token de verificación
            $token = bin2hex(random_bytes(32));

            // Validar token generado (debe tener longitud específica y formato hexadecimal)
            if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
                error_log("Token inválido: " . $token);
                throw new Exception("Error al generar el token de verificación.");
            }

            // Hashear la contraseña
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);

            // Insertar usuario con el token
            $query = "INSERT INTO usuario (primer_nombre, correo, contrasena, token_verificacion, verificado) 
                     VALUES (?, ?, ?, ?, FALSE)";
            $params = [$datos['primer_nombre'], $datos['email'], $passwordHash, $token];
            
            // Log para verificar los parámetros
            error_log("Parámetros de inserción: " . json_encode($params));

            $this->pdo->insert($query, $params);

            $urlVerificacion = $this->urlBase . "?token=" . urlencode($token);

            // Validar que la URL generada es válida
            if (!filter_var($urlVerificacion, FILTER_VALIDATE_URL)) {
                error_log("URL inválida: " . $urlVerificacion);
                throw new Exception("Error al generar la URL de verificación.");
            }

            // Enviar correo
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
    try {
        $datos = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($datos['email'], $datos['primer_nombre'], $datos['password']) ||
            !filter_var($datos['email'], FILTER_VALIDATE_EMAIL) ||
            strlen($datos['primer_nombre']) < 2 ||
            strlen($datos['password']) < 8) {
            throw new Exception('Datos inválidos o incompletos');
        }

        $registro = new Registrar();
        $resultado = $registro->registrarUsuario($datos);
        
        header('Content-Type: application/json');
        echo json_encode($resultado);
        
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'errors' => [$e->getMessage()]
        ]);
    }
    exit;
}
?>
