<?php
class Database 
{
    // Declaración de una propiedad
    private $hostname = 'localhost';
    private $database = 'glosajeweb03';
    private $username = 'root';
    private $password = "";
    private $charset = 'utf8';
    private $port = 3308;

    // Declaración de un método
    function conectar()
    {
        try{
            $conexion = "mysql:host=" . $this->hostname . ";port=" .$this->port. ";dbname=" . $this->database  . ";charset=" . $this->charset; 
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($conexion,$this->username,$this->password,$options);
        return $pdo;
        }catch(PDOException $e){
            echo"Error conexión: " . $e->getMessage();
            exit;
        }
        
    }
}
?>