<?php
$host = 'localhost';
$banco = 'logistica';
$usuario = 'root';
$senha = ''; // Padrão do XAMPP. Se você definiu uma senha no MySQL, informe aqui.

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die('Não foi possível conectar ao banco de dados. Confira se o MySQL está ligado e se importou database/logistica.sql.');
}
