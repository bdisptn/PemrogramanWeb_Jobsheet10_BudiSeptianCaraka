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
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM presensi WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Catatan presensi berhasil dihapus.'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal menghapus presensi: ' . $e->getMessage()];
        }
    }
}

header('Location: list.php');
exit;