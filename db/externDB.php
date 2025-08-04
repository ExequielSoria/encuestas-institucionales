<?php
// Conexión a la base de datos externa

//Libreria para leer el .env
require_once __DIR__ . '/../vendor/autoload.php';

//Movida rara de rutas para encontrar el .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


//Defino las variables de entorno
$host = $_ENV['EXTERNAL_MYSQL_HOST'];
$dbname = $_ENV['EXTERNAL_DATABASE_NAME'];
$user = $_ENV['EXTERNAL_MYSQL_USER'];
$pass = $_ENV['EXTERNAL_MYSQL_PASS'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}