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
    $kegiatan = trim($_POST['kegiatan'] ?? '');
    $tanggal = trim($_POST['tanggal'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $poin = trim($_POST['poin'] ?? '0');

    $errors = [];

    if (empty($nim) || !ctype_digit($nim)) {
        $errors[] = "NIM wajib berupa angka.";
    }

    if (empty($nama)) {
        $errors[] = "Nama Mahasiswa wajib diisi.";
    }

    if (empty($kegiatan)) {
        $errors[] = "Nama Kegiatan wajib diisi.";
    }

    if (empty($tanggal)) {
        $errors[] = "Tanggal wajib diisi.";
    }

    if (!is_numeric($poin) || $poin < 0) {
        $errors[] = "Poin tidak boleh bernilai negatif.";
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
        $sql = "INSERT INTO presensi (nim, nama, kegiatan, tanggal, status, poin) 
                VALUES (:nim, :nama, :kegiatan, :tanggal, :status, :poin) RETURNING id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nim'      => $nim,
            ':nama'     => $nama,
            ':kegiatan' => $kegiatan,
            ':tanggal'  => $tanggal,
            ':status'   => $status,
            ':poin'     => (int)$poin
        ]);

        $newId = $stmt->fetchColumn();

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Catatan presensi berhasil disimpan ke database!'
        ];

        header('Location: list.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan presensi ke database: ' . $e->getMessage()
        ];
        header('Location: tambah.php');
        exit;
    }
}