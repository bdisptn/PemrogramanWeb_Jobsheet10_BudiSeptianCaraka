<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
include '../includes/header.php';
?>

<?php
session_start();
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $ukm = trim($_POST['ukm'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');

    $errors = [];

    // Validasi Server-Side
    if (empty($nim)) {
        $errors[] = "NIM wajib diisi.";
    } elseif (!ctype_digit($nim)) {
        $errors[] = "NIM harus berupa angka.";
    }

    if (empty($nama)) {
        $errors[] = "Nama Anggota wajib diisi.";
    }

    if (empty($ukm)) {
        $errors[] = "Nama UKM wajib diisi.";
    }

    if (!empty($errors)) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => implode('<br>', $errors)
        ];
        header('Location: tambah.php');
        exit;
    }

    try {
        // Query INSERT dengan Prepared Statement & RETURNING id
        $sql = "INSERT INTO anggota (nim, nama, ukm, jabatan) VALUES (:nim, :nama, :ukm, :jabatan) RETURNING id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nim'     => $nim,
            ':nama'    => $nama,
            ':ukm'     => $ukm,
            ':jabatan' => $jabatan
        ]);

        $newId = $stmt->fetchColumn(); // Mendapatkan ID yang baru dibuat

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Data anggota berhasil disimpan ke database!'
        ];

        header('Location: list.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan data ke database: ' . $e->getMessage()
        ];
        header('Location: tambah.php');
        exit;
    }
}