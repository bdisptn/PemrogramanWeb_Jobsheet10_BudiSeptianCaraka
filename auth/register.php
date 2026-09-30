<?php
$base = "../";
$title = "Registrasi Petugas - AbsenUKM";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, redirect langsung ke beranda
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

include '../includes/header.php';
?>

<section class="auth-card">
  <h2>Registrasi Petugas Baru</h2>

  <form action="proses_register.php" method="post">
    <div class="form-group">
      <label for="nama">Nama Lengkap:</label>
      <input type="text" id="nama" name="nama" required>
    </div>

    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="btn-simpan">Daftar Akun</button>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </form>
</section>

<?php include '../includes/footer.php'; ?>