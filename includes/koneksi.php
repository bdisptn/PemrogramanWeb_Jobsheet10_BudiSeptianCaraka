<?php
// Membaca variabel dari Railway melalui $_ENV, getenv(), atau $_SERVER
$host     = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?? $_SERVER['DB_HOST']     ?? 'localhost';
$port     = $_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?? $_SERVER['DB_PORT']     ?? '5432';
$database = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?? $_SERVER['DB_NAME']     ?? 'absen_ukm';
$user     = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?? $_SERVER['DB_USER']     ?? 'postgres';
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? $_SERVER['DB_PASSWORD'] ?? '130905';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>