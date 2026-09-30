<?php
// Konfigurasi Database
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'absen_ukm';
$user = getenv('DB_USER') ?: 'postgres';
$pass = getenv('DB_PASSWORD') ?: '130905';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    // Membuat instance PDO
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Tampilkan pesan jika koneksi gagal
    die("Koneksi Database Gagal: " . $e->getMessage());
}