<?php
// Aiven MySQL Connection Settings
$host = 'mysql-341ee862-slrapapp147-df6a.b.aivencloud.com';
$port = '16699';
$db   = 'defaultdb';
$user = 'avnadmin';

// Password එක Server Environment Variables වලින් ලබා ගනී (Hardcode කර නැත)
$pass = getenv('DB_PASS');

// SSL Certificate Path
$ssl_ca = __DIR__ . '/ca.pem';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_SSL_CA             => $ssl_ca,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Database Connection Failed"]);
    exit();
}
?>
