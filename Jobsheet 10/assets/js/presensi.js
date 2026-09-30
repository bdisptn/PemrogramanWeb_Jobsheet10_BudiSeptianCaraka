/**
 * Render Data Presensi UKM via Fetch API & JSON (Jobsheet 6)
 */
document.addEventListener("DOMContentLoaded", function () {
  loadPresensiData();
});

async function loadPresensiData() {
  const tbody = document.querySelector("#tabel-presensi tbody");
  const loadingIndicator = document.getElementById("loading-indicator");

  if (!tbody) return;

  if (loadingIndicator) loadingIndicator.style.display = "block";

  try {
    // Simulasi delay 600ms
    await new Promise((resolve) => setTimeout(resolve, 600));

    const response = await fetch("../data/presensi.json");

    if (!response.ok) {
      throw new Error(`Gagal memuat data (Status: ${response.status})`);
    }

    const data = await response.json();

    if (loadingIndicator) loadingIndicator.style.display = "none";
    tbody.innerHTML = "";

    if (data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="7" class="text-center">Belum ada data presensi.</td></tr>`;
      return;
    }

    data.forEach((item, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${item.nim}</td>
        <td><strong>${item.nama}</strong></td>
        <td>${item.kegiatan}</td>
        <td>${item.tanggal}</td>
        <td><span class="badge-${item.status.toLowerCase()}">${item.status}</span></td>
        <td>
          <button class="btn-edit" data-id="${item.id}">Edit</button>
          <button class="btn-hapus" data-id="${item.id}">Hapus</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  } catch (error) {
    if (loadingIndicator) loadingIndicator.style.display = "none";
    tbody.innerHTML = `
      <tr class="baris-kosong">
        <td colspan="7" style="color: var(--danger); text-align: center; padding: 1.5rem;">
          ❌ Error: ${error.message}. Gagal mengambil data presensi.
        </td>
      </tr>
    `;
  }
}