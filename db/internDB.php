<?php
// Conexión a la base de datos interna

//Libreria para leer el .env
require '../vendor/autoload.php';

//Movida rara de rutas para encontrar el .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


//Defino las variables de entorno
$host = $_ENV['MYSQL_HOST'];
$dbname = $_ENV['DATABASE_NAME'];
$user = $_ENV['MYSQL_USER'];
$pass = $_ENV['MYSQL_PASS'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
