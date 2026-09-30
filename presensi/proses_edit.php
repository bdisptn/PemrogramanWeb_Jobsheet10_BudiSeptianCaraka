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
    $id       = $_POST['id'] ?? null;
    $nim      = trim($_POST['nim'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $kegiatan = trim($_POST['kegiatan'] ?? '');
    $tanggal  = trim($_POST['tanggal'] ?? '');
    $status   = trim($_POST['status'] ?? 'Hadir');
    $poin     = trim($_POST['poin'] ?? '0');

    if (!$id || empty($nim) || empty($nama) || empty($kegiatan)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Kolom wajib harus diisi.'];
        header("Location: edit.php?id=$id");
        exit;
    }

    try {
        $sql = "UPDATE presensi SET nim = :nim, nama = :nama, kegiatan = :kegiatan, tanggal = :tanggal, status = :status, poin = :poin WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nim'      => $nim,
            ':nama'     => $nama,
            ':kegiatan' => $kegiatan,
            ':tanggal'  => $tanggal,
            ':status'   => $status,
            ':poin'     => (int)$poin,
            ':id'       => $id
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Catatan presensi berhasil diperbarui!'];
        header('Location: list.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal memperbarui presensi: ' . $e->getMessage()];
        header("Location: edit.php?id=$id");
        exit;
    }
}