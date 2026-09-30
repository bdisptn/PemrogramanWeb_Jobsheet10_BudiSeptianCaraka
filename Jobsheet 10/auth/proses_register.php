<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nama) || empty($username) || empty($password)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Semua kolom wajib diisi.'];
        header('Location: register.php');
        exit;
    }

    // Cek apakah username sudah dipakai
    $stmtCek = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmtCek->execute([':username' => $username]);
    if ($stmtCek->fetch()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username sudah digunakan, cari username lain.'];
        header('Location: register.php');
        exit;
    }

    // Hash Password sebelum disimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (nama, username, password) VALUES (:nama, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama'     => $nama,
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registrasi berhasil! Silakan login.'];
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal mendaftar: ' . $e->getMessage()];
        header('Location: register.php');
        exit;
    }
}