<?php
$base = "../";
$title = "Login Petugas - AbsenUKM";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

include '../includes/header.php';
?>

<section class="auth-card">
  <h2>Login Petugas AbsenUKM</h2>

  <form action="proses_login.php" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="btn-simpan">Masuk</button>
    <p>Belum punya akun? <a href="register.php">Daftar Petugas Baru</a></p>
  </form>
</section>

<?php include '../includes/footer.php'; ?>