/**
 * Render Data Anggota UKM via Fetch API & JSON (Jobsheet 6)
 */
document.addEventListener("DOMContentLoaded", function () {
  loadAnggotaData();
});

async function loadAnggotaData() {
  const tbody = document.querySelector("#tabel-anggota tbody");
  const loadingIndicator = document.getElementById("loading-indicator");

  if (!tbody) return;

  // Tampilkan loading indicator
  if (loadingIndicator) loadingIndicator.style.display = "block";

  try {
    // Simulasi delay jaringan 600ms sesuai instruksi Jobsheet 6
    await new Promise((resolve) => setTimeout(resolve, 600));

    const response = await fetch("../data/anggota.json");

    if (!response.ok) {
      throw new Error(`Gagal memuat data (Status: ${response.status})`);
    }

    const data = await response.json();

    // Sembunyikan loading
    if (loadingIndicator) loadingIndicator.style.display = "none";

    // Kosongkan tbody sebelum render
    tbody.innerHTML = "";

    if (data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="6" class="text-center">Belum ada data anggota.</td></tr>`;
      return;
    }

    // Render baris data
    data.forEach((anggota, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${anggota.nim}</td>
        <td><strong>${anggota.nama}</strong></td>
        <td>${anggota.ukm}</td>
        <td>${anggota.jabatan}</td>
        <td>
          <button class="btn-edit" data-id="${anggota.id}">Edit</button>
          <button class="btn-hapus" data-id="${anggota.id}">Hapus</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  } catch (error) {
    if (loadingIndicator) loadingIndicator.style.display = "none";
    tbody.innerHTML = `
      <tr class="baris-kosong">
        <td colspan="6" style="color: var(--danger); text-align: center; padding: 1.5rem;">
          ❌ Error: ${error.message}. Gagal mengambil data anggota.
        </td>
      </tr>
    `;
  }
}