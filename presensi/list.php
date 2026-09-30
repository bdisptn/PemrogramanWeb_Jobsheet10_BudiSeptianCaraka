<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
require_once '../includes/header.php';
?>

<?php
$base = "../";
$title = "Daftar Presensi - AbsenUKM";

require_once '../includes/koneksi.php';
require_once '../includes/header.php';

$q = trim($_GET['q'] ?? '');
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Total Data Presensi
if ($q !== '') {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM presensi WHERE nama ILIKE :kw OR kegiatan ILIKE :kw");
    $countStmt->execute([':kw' => "%$q%"]);
} else {
    $countStmt = $pdo->query("SELECT COUNT(*) FROM presensi");
}
$totalData = $countStmt->fetchColumn();
$totalPages = ceil($totalData / $limit);

// Query Data Presensi
if ($q !== '') {
    $stmt = $pdo->prepare("SELECT * FROM presensi WHERE nama ILIKE :kw OR kegiatan ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':kw', "%$q%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM presensi ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}
$presensiList = $stmt->fetchAll();
?>

<section>
  <h2>Daftar Presensi Kegiatan</h2>
  <p><a href="tambah.php" class="btn-tambah">+ Catat Presensi Baru</a></p>

  <form method="get" action="list.php" class="search-form">
    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari nama atau kegiatan...">
    <button type="submit">Cari</button>
    <?php if ($q !== ''): ?>
      <a href="list.php" class="btn-reset">Reset</a>
    <?php endif; ?>
  </form>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama Anggota</th>
          <th>Kegiatan</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Poin</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($presensiList)): ?>
          <tr class="baris-kosong">
            <td colspan="8">Data presensi tidak ditemukan.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($presensiList as $index => $row): ?>
            <tr>
              <td><?= $offset + $index + 1 ?></td>
              <td><?= htmlspecialchars($row['nim']) ?></td>
              <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
              <td><?= htmlspecialchars($row['kegiatan']) ?></td>
              <td><?= htmlspecialchars($row['tanggal']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td><?= htmlspecialchars($row['poin']) ?></td>
              <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                <form action="hapus.php" method="post" class="form-hapus" style="display:inline;">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <button type="submit" class="btn-hapus">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&q=<?= urlencode($q) ?>" class="<?= $i === $page ? 'active' : '' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>