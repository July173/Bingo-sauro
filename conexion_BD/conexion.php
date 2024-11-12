<?php
    class Conexion{
        private $servidor;
        private $usuario;
        private $password;
        private $puerto;
        private $baseDatos;
        private $pdo;

        public function __construct(){
            $this->servidor="bwbup4izlyky4o7s56rs-mysql.services.clever-cloud.com";
            $this->usuario="ueux843bklbuh0jv";
            $this->password="kJ2Xvm2k1YPrn9gEHKK2";
            $this->puerto="3306";
            $this->baseDatos="bwbup4izlyky4o7s56rs";
            $this->pdo=$this->conectar();
        }

        public function conectar(){
            try {
                $dsn = "mysql:host=$this->servidor;port=$this->puerto;dbname=$this->baseDatos";
                $this->pdo = new PDO($dsn, $this->usuario, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
                return $this->pdo;
            } catch (PDOException $e) {
                throw new Exception('Error en la conexión: ' . $e->getMessage());
            }
        }
    }
?>