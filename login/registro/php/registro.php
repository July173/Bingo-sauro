<?php
header('Content-Type: application/json'); // Asegurarnos de que la respuesta sea JSON
require '../../../conexion_BD/conexion.php';
require '../inicio-sesion/php/desbloqueados-por-defecto.php'; // Incluir la función desbloquearArticulosPorDefecto

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
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);

            // Insertar usuario con el token
            $query = "INSERT INTO usuario (primer_nombre, correo, contrasena, token_verificacion, verificado) 
                      VALUES (?, ?, ?, ?, FALSE)";
            $params = [$datos['primer_nombre'], $datos['email'], $passwordHash, $token];
            $this->pdo->insert($query, $params);

            // Obtener el ID del usuario recién registrado
            $id_usuario = $this->pdo->conectar()->lastInsertId(); // Obtener el último ID insertado

            // Desbloquear artículos por defecto para el usuario
            agregarArticulosDesbloqueadosPorDefecto($this->pdo->conectar(), $id_usuario);
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
