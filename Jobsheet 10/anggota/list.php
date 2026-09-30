<?php
$base = "../";
require_once '../includes/auth.php'; // Guard diletakkan di paling atas
require_once '../includes/koneksi.php';
require_once '../includes/header.php';
?>

<?php
$base = "../";
$title = "Daftar Anggota - AbsenUKM";

require_once '../includes/koneksi.php';
require_once '../includes/header.php';

// Parameter Pencarian & Pagination
$q = trim($_GET['q'] ?? '');
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit = 5; // 5 data per halaman
$offset = ($page - 1) * $limit;

// Menghitung Total Data (Filter Search Server-side)
if ($q !== '') {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :kw OR nim ILIKE :kw OR ukm ILIKE :kw");
    $countStmt->execute([':kw' => "%$q%"]);
} else {
    $countStmt = $pdo->query("SELECT COUNT(*) FROM anggota");
}
$totalData = $countStmt->fetchColumn();
$totalPages = ceil($totalData / $limit);

// Query Data Berdasarkan Halaman & Pencarian
if ($q !== '') {
    $stmt = $pdo->prepare("SELECT * FROM anggota WHERE nama ILIKE :kw OR nim ILIKE :kw OR ukm ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':kw', "%$q%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}
$anggotaList = $stmt->fetchAll();
?>

<section>
  <h2>Daftar Anggota UKM</h2>
  <p><a href="tambah.php" class="btn-tambah">+ Tambah Anggota Baru</a></p>

  <!-- Form Pencarian Server-Side -->
  <form method="get" action="list.php" class="search-form">
    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari nama, NIM, atau UKM...">
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
          <th>UKM</th>
          <th>Jabatan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($anggotaList)): ?>
          <tr class="baris-kosong">
            <td colspan="6">Data anggota tidak ditemukan.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($anggotaList as $index => $row): ?>
            <tr>
              <td><?= $offset + $index + 1 ?></td>
              <td><?= htmlspecialchars($row['nim']) ?></td>
              <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
              <td><?= htmlspecialchars($row['ukm']) ?></td>
              <td><?= htmlspecialchars($row['jabatan']) ?></td>
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

  <!-- Pagination Navigasi -->
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

<?php require_once '../includes/footer.php'; ?>