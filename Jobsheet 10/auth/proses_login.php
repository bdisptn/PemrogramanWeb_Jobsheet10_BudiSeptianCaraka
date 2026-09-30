<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username dan Password wajib diisi.'];
        header('Location: login.php');
        exit;
    }

    // Cari user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    // Verifikasi keberadaan user dan kecocokan hash password
    if ($user && password_verify($password, $user['password'])) {
        // Buat Sesi Login
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['nama']     = $user['nama'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Selamat datang kembali, ' . htmlspecialchars($user['nama']) . '!'];
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username atau Password salah!'];
        header('Location: login.php');
        exit;
    }
}