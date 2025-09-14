<?php


require_once __DIR__ . '/../vendor/autoload.php';



$host =getenv("DB_HOST");
$db = getenv('MYSQL_DATABASE');
$user = 'root';
$password = getenv('MYSQL_ROOT_PASSWORD');

try {
    // $conn = new PDO("mysql: host=$host,dbname=$db, $user, $password");
    $conn = new PDO("mysql:host=db;port=3306;dbname=Hackathon2025;", $user, "educ_atI0n*");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
