<?php
declare(strict_types=1);

class Database {
    private string $host = 'localhost';
    private string $dbname = 'electronics_catalog';
    private string $user = 'root'; // Update with your DB user
    private string $pass = ''; // Update with your DB password
    private ?PDO $pdo = null;

    public function getConnection(): PDO {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
            return $this->pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
?>