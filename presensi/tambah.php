<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
include '../includes/header.php';
?>

<?php
$base = "../";
$title = "Tambah Presensi - AbsenUKM";
include '../includes/header.php';
?>

<section>
  <h2>Formulir Presensi Kegiatan</h2>
  <form action="proses_tambah.php" method="post">
    <fieldset>
      <legend>Input Presensi</legend>
      <p>
        <label for="nim">NIM Mahasiswa:</label>
        <input type="text" id="nim" name="nim" required>
      </p>
      <p>
        <label for="nama">Nama Mahasiswa:</label>
        <input type="text" id="nama" name="nama" required>
      </p>
      <p>
        <label for="kegiatan">Nama Kegiatan:</label>
        <input type="text" id="kegiatan" name="kegiatan" required>
      </p>
      <p>
        <label for="tanggal">Tanggal Kegiatan:</label>
        <input type="date" id="tanggal" name="tanggal" required>
      </p>
      <p>
        <label for="status">Status Kehadiran:</label>
        <select id="status" name="status" required>
          <option value="Hadir">Hadir</option>
          <option value="Izin">Izin</option>
          <option value="Sakit">Sakit</option>
        </select>
      </p>
      <p>
        <label for="poin">Poin Kehadiran:</label>
        <input type="number" id="poin" name="poin" value="10" min="0" required>
      </p>
      <p>
        <button type="submit">Simpan Presensi</button>
        <button type="reset">Reset</button>
      </p>
    </fieldset>
  </form>
</section>

<?php include '../includes/footer.php'; ?>