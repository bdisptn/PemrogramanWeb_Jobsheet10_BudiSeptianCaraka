<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
include '../includes/header.php';
?>

<?php
$base = "../";
$title = "Ubah Presensi - AbsenUKM";

require_once '../includes/koneksi.php';
include '../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM presensi WHERE id = :id");
$stmt->execute([':id' => $id]);
$presensi = $stmt->fetch();

if (!$presensi) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data presensi tidak ditemukan.'];
    header('Location: list.php');
    exit;
}
?>

<section>
  <h2>Ubah Catatan Presensi</h2>

  <form action="proses_edit.php" method="post">
    <input type="hidden" name="id" value="<?= $presensi['id'] ?>">

    <div class="form-group">
      <label for="nim">NIM:</label>
      <input type="text" id="nim" name="nim" value="<?= htmlspecialchars($presensi['nim']) ?>" required>
    </div>

    <div class="form-group">
      <label for="nama">Nama Mahasiswa:</label>
      <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($presensi['nama']) ?>" required>
    </div>

    <div class="form-group">
      <label for="kegiatan">Nama Kegiatan:</label>
      <input type="text" id="kegiatan" name="kegiatan" value="<?= htmlspecialchars($presensi['kegiatan']) ?>" required>
    </div>

    <div class="form-group">
      <label for="tanggal">Tanggal:</label>
      <input type="date" id="tanggal" name="tanggal" value="<?= htmlspecialchars($presensi['tanggal']) ?>" required>
    </div>

    <div class="form-group">
      <label for="status">Status Kehadiran:</label>
      <select id="status" name="status">
        <option value="Hadir" <?= $presensi['status'] === 'Hadir' ? 'selected' : '' ?>>Hadir</option>
        <option value="Izin" <?= $presensi['status'] === 'Izin' ? 'selected' : '' ?>>Izin</option>
        <option value="Sakit" <?= $presensi['status'] === 'Sakit' ? 'selected' : '' ?>>Sakit</option>
        <option value="Alpha" <?= $presensi['status'] === 'Alpha' ? 'selected' : '' ?>>Alpha</option>
      </select>
    </div>

    <div class="form-group">
      <label for="poin">Poin Kegiatan:</label>
      <input type="number" id="poin" name="poin" value="<?= htmlspecialchars($presensi['poin']) ?>" min="0">
    </div>

    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
    <a href="list.php" class="btn-batal">Batal</a>
  </form>
</section>

<?php include '../includes/footer.php'; ?>