<?php


require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$host = $_ENV['DB_HOST'];
$db = $_ENV['MYSQL_DATABASE'];
$user = 'root';
$password = $_ENV['MYSQL_ROOT_PASSWORD'];

try{
    $conn = new PDO("mysql: host=$host,dbname=$db, $user, $password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection failed: ". $e->getMessage();
}
