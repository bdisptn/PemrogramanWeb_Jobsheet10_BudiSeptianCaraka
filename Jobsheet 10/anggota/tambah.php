<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
include '../includes/header.php';
?>

<?php
$base = "../";
$title = "Tambah Anggota - AbsenUKM";
include '../includes/header.php';
?>

<section>
  <h2>Formulir Tambah Anggota</h2>
  <form action="proses_tambah.php" method="post">
    <fieldset>
      <legend>Data Anggota Baru</legend>
      <p>
        <label for="nim">NIM Mahasiswa:</label>
        <input type="text" id="nim" name="nim" required>
      </p>
      <p>
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" required>
      </p>
      <p>
        <label for="ukm">Nama UKM:</label>
        <input type="text" id="ukm" name="ukm" required>
      </p>
      <p>
        <label for="jabatan">Jabatan:</label>
        <input type="text" id="jabatan" name="jabatan" placeholder="Contoh: Anggota / Pengurus" required>
      </p>
      <p>
        <button type="submit">Simpan Data</button>
        <button type="reset">Reset</button>
      </p>
    </fieldset>
  </form>
</section>

<?php include '../includes/footer.php'; ?>