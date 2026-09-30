<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'AbsenUKM' ?></title>
  <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
</head>
<body>
  <header class="main-header">
    <div class="header-container">
      <h1 class="brand-title">AbsenUKM</h1>
      <nav class="main-nav">
        <ul class="nav-list">
          <li><a href="<?= $base ?>index.php">Beranda</a></li>
          <li><a href="<?= $base ?>presensi/list.php">Presensi Kegiatan</a></li>
          
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="<?= $base ?>anggota/list.php">Kelola Anggota</a></li>
            <li class="user-badge">
              <span class="user-name">Petugas: <strong><?= htmlspecialchars($_SESSION['nama'] ?? '') ?></strong></span>
              <a href="<?= $base ?>auth/logout.php" class="btn-logout">Logout</a>
            </li>
          <?php else: ?>
            <li><a href="<?= $base ?>auth/login.php" class="btn-login">Login Petugas</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">