<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.'
    ];

    // Tentukan jalur relatif menuju halaman login
    $loginUrl = isset($base) ? $base . 'auth/login.php' : '../auth/login.php';
    header("Location: " . $loginUrl);
    exit; // Wajib dipanggil untuk menghentikan eksekusi script selanjutnya
}