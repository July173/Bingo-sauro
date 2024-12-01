<?php
header('Content-Type: application/json'); // Asegurarnos de que la respuesta sea JSON
require '../../../conexion_BD/conexion.php';
require 'desbloqueados-por-defecto.php';

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
        error_log("Esto es un mensaje de prueba para verificar los logs.");

    }

    public function registrarUsuario($datos) {
        try {
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
                error_log("Correo ya registrado: " . $datos['email']);
                $this->response['errors'][] = "El correo ya está registrado";
                return $this->response;
            }

            // Generar token de verificación
            $token = bin2hex(random_bytes(32));

            // Validar token generado
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

            error_log("Parámetros de inserción: " . json_encode($params));

            $this->pdo->insert($query, $params);

            // Obtener el ID del usuario recién registrado
            $id_usuario = $this->pdo->conectar()->lastInsertId();
            error_log("ID del usuario recién creado: $id_usuario");

            // Desbloquear artículos por defecto para el usuario
            error_log("Llamando a agregarArticulosDesbloqueadosPorDefecto...");
            $resultado = agregarArticulosDesbloqueadosPorDefecto($this->pdo->conectar(), $id_usuario);
            error_log("Resultado de la función: " . $resultado);

            // Generar URL de verificación
            $urlVerificacion = $this->urlBase . "?token=" . urlencode($token);

            // Validar URL
            if (!filter_var($urlVerificacion, FILTER_VALIDATE_URL)) {
                error_log("URL inválida: " . $urlVerificacion);
                throw new Exception("Error al generar la URL de verificación.");
            }

            // Enviar correo
            enviarCorreoBienvenida($datos['email'], $datos['primer_nombre'], $token);

            error_log("Correo de bienvenida enviado a: " . $datos['email']);

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

        error_log("Datos de registro recibidos: " . json_encode($datos));

        $registro = new Registrar();
        $resultado = $registro->registrarUsuario($datos);

        header('Content-Type: application/json');
        echo json_encode($resultado);

    } catch (Exception $e) {
        error_log("Error procesando la solicitud POST: " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'errors' => [$e->getMessage()]
        ]);
    }
    exit;
}


?>
