<?php
/**
 * Configurações de conexão com o banco de dados
 * FacilTecnologia - Testes
 */

class DatabaseConfig {
    private static $host = 'localhost';
    private static $dbname = 'sistema_contratos';
    private static $username = 'root';
    private static $password = '';
    
    public static function getConnection() {
        try {
            $pdo = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8", 
                self::$username, 
                self::$password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
    
    public static function testConnection() {
        try {
            $pdo = self::getConnection();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
