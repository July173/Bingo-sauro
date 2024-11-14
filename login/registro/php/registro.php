<?php
header('Content-Type: application/json'); // Asegurarnos de que la respuesta sea JSON
// require_once '../../../conexion_BD/conexion.php';
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

            // Hashear la contraseña
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);

            // Insertar usuario usando la función insert
            $query = "INSERT INTO usuario (primer_nombre, correo, contrasena) VALUES (?, ?, ?)";
            $params = [$datos['primer_nombre'], $datos['email'], $passwordHash];
            $this->pdo->insert($query, $params);

            $this->response['success'] = true;
            $this->response['message'] = "Usuario registrado exitosamente";
        } catch (PDOException $e) {
            $this->response['errors'][] = "Error al registrar: " . $e->getMessage();
        } catch (Exception $e) {
            $this->response['errors'][] = "Error inesperado: " . $e->getMessage();
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