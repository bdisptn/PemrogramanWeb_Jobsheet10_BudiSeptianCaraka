<?php
$base = "";
$title = "Beranda - AbsenUKM";

require_once 'includes/koneksi.php';
require_once 'includes/header.php';

// Hitung total anggota dari database
$stmtAnggota = $pdo->query("SELECT COUNT(*) FROM anggota");
$total_anggota = $stmtAnggota->fetchColumn();

// Hitung total presensi dari database
$stmtPresensi = $pdo->query("SELECT COUNT(*) FROM presensi");
$total_presensi = $stmtPresensi->fetchColumn();
?>

<section>
  <h2>Selamat Datang di AbsenUKM</h2>
  <p>Sistem informasi pengelolaan data anggota dan presensi kegiatan Unit Kegiatan Mahasiswa.</p>
</section>

<section>
  <h2>Statistik Ringkas</h2>
  <article>
    <h3>Total Anggota</h3>
    <p><?= $total_anggota ?> Mahasiswa</p>
  </article>
  <article>
    <h3>Total Presensi</h3>
    <p><?= $total_presensi ?> Catatan</p>
  </article>
</section>

<?php require_once 'includes/footer.php'; ?>