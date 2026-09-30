<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
include '../includes/header.php';
?>

<?php
$base = "../";
$title = "Ubah Anggota - AbsenUKM";

require_once '../includes/koneksi.php';
include '../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

// Ambil data anggota berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute([':id' => $id]);
$anggota = $stmt->fetch();

if (!$anggota) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}
?>

<section>
  <h2>Ubah Data Anggota</h2>

  <?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
      <?= $_SESSION['flash']['message'] ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
  <?php endif; ?>

  <form action="proses_edit.php" method="post">
    <input type="hidden" name="id" value="<?= $anggota['id'] ?>">

    <div class="form-group">
      <label for="nim">NIM:</label>
      <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($anggota['nim']) ?>" required>
    </div>

    <div class="form-group">
      <label for="nama">Nama Anggota:</label>
      <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($anggota['nama']) ?>" required>
    </div>

    <div class="form-group">
      <label for="ukm">Nama UKM:</label>
      <input type="text" id="ukm" name="ukm" value="<?= htmlspecialchars($anggota['ukm']) ?>" required>
    </div>

    <div class="form-group">
      <label for="jabatan">Jabatan:</label>
      <input type="text" id="jabatan" name="jabatan" value="<?= htmlspecialchars($anggota['jabatan']) ?>" required>
    </div>

    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
    <a href="list.php" class="btn-batal">Batal</a>
  </form>
</section>

<?php include '../includes/footer.php'; ?>