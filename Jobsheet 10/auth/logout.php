<?php
session_start();

// Hapus seluruh variabel session
session_unset();

// Hancurkan session
session_destroy();

// Mulai session baru khusus untuk menampung pesan flash
session_start();
$_SESSION['flash'] = ['type' => 'success', 'message' => 'Anda telah berhasil logout.'];

header('Location: login.php');
exit;