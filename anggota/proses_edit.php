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
    $id      = $_POST['id'] ?? null;
    $nim     = trim($_POST['nim'] ?? '');
    $nama    = trim($_POST['nama'] ?? '');
    $ukm     = trim($_POST['ukm'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');

    if (!$id || empty($nim) || empty($nama) || empty($ukm)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Semua kolom wajib diisi.'];
        header("Location: edit.php?id=$id");
        exit;
    }

    try {
        $sql = "UPDATE anggota SET nim = :nim, nama = :nama, ukm = :ukm, jabatan = :jabatan WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nim'     => $nim,
            ':nama'    => $nama,
            ':ukm'     => $ukm,
            ':jabatan' => $jabatan,
            ':id'      => $id
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data anggota berhasil diperbarui!'];
        header('Location: list.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal memperbarui data: ' . $e->getMessage()];
        header("Location: edit.php?id=$id");
        exit;
    }
}