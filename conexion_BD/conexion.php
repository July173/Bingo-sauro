<?php
class Conexion
{
    private $servidor;
    private $usuario;
    private $password;
    private $puerto;
    private $baseDatos;
    private $pdo;

    public function __construct()
    {
        $this->servidor = "bwbup4izlyky4o7s56rs-mysql.services.clever-cloud.com";
        $this->usuario = "ueux843bklbuh0jv";
        $this->password = "kJ2Xvm2k1YPrn9gEHKK2";
        $this->puerto = "3306";
        $this->baseDatos = "bwbup4izlyky4o7s56rs";
        $this->pdo = $this->conectar();
    }

    public function conectar()
    {
        try {
            $dsn = "mysql:host=$this->servidor;port=$this->puerto;dbname=$this->baseDatos;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false // Desactivar la emulación de preparaciones
            ];
            $this->pdo = new PDO($dsn, $this->usuario, $this->password, $options);
            return $this->pdo;
        } catch (PDOException $e) {
            throw new Exception('Error en la conexión: ' . $e->getMessage());
        }
    }

    // Función genérica para INSERT con retorno del último ID
    public function insert($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $this->pdo->lastInsertId(); // Retorna el último ID generado
        } catch (PDOException $e) {
            error_log("Error en insert: " . $e->getMessage());
            throw new Exception("Error en la inserción: " . $e->getMessage());
        }
    }

    // Función genérica para SELECT
    public function select($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(); // Retorna todos los resultados
        } catch (PDOException $e) {
            throw new Exception('Error al consultar: ' . $e->getMessage());
        }
    }

    // Función genérica para UPDATE
    public function update($query, $params)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params); // Retorna true si se ejecutó correctamente
        } catch (PDOException $e) {
            throw new Exception('Error al actualizar: ' . $e->getMessage());
        }
    }

    // Función genérica para DELETE
    public function delete($query, $params)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute($params); // Retorna true si se ejecutó correctamente
        } catch (PDOException $e) {
            throw new Exception('Error al eliminar: ' . $e->getMessage());
        }
    }
}
?>
