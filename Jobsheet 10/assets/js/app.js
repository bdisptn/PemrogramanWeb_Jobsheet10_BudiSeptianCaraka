/**
 * AbsenUKM — JavaScript DOM & Event (Jobsheet 5)
 * Sistem Absensi & Kegiatan Unit Kegiatan Mahasiswa
 */

document.addEventListener('DOMContentLoaded', () => {
    // Handling Konfirmasi Hapus pada Form Hapus
    const formHapusList = document.querySelectorAll('.form-hapus');
    formHapusList.forEach(form => {
        form.addEventListener('submit', (e) => {
            const setuju = confirm('Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.');
            if (!setuju) {
                e.preventDefault(); // Batalkan pengiriman form jika pengguna klik Cancel
            }
        });
    });
});

/* 1. Hamburger Menu Toggle (Navigasi Responsive Jobsheet 5) */
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn") || 
                    document.querySelector(".menu-button") || 
                    document.querySelector(".nav-toggle-label");
  const nav = document.querySelector("nav");

  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function (e) {
    e.preventDefault();
    // Menggunakan classList.toggle sesuai spesifikasi Jobsheet 5
    const isOpen = nav.classList.toggle("nav-open");
    toggleBtn.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });
}

/* 2. Real-Time Table Filter (Pencarian Baris via keyup/input) */
function initTableFilter() {
  const searchInputs = document.querySelectorAll("#search-input, input[data-tabel]");

  searchInputs.forEach(function (input) {
    const handleFilter = function () {
      const targetTableId = input.getAttribute("data-tabel");
      let table = targetTableId ? document.getElementById(targetTableId) : document.querySelector("table");

      if (!table) return;

      const filterText = input.value.toLowerCase().trim();
      const tbody = table.querySelector("tbody");
      if (!tbody) return;

      const rows = tbody.querySelectorAll("tr:not(.baris-kosong)");
      let matchCount = 0;

      rows.forEach(function (row) {
        const text = row.textContent.toLowerCase();
        if (filterText === "" || text.includes(filterText)) {
          row.style.display = "";
          matchCount++;
        } else {
          row.style.display = "none";
        }
      });

      // Status visual jika data absensi/kegiatan tidak ditemukan
      let noDataRow = tbody.querySelector(".baris-kosong");
      if (matchCount === 0) {
        if (!noDataRow) {
          const totalCols = table.querySelectorAll("thead th").length || 5;
          noDataRow = document.createElement("tr");
          noDataRow.className = "baris-kosong";
          noDataRow.innerHTML = `<td colspan="${totalCols}">Data tidak ditemukan</td>`;
          tbody.appendChild(noDataRow);
        } else {
          noDataRow.style.display = "";
        }
      } else if (noDataRow) {
        noDataRow.style.display = "none";
      }
    };

    // Event listener keyup & input sesuai petunjuk Jobsheet 5
    input.addEventListener("keyup", handleFilter);
    input.addEventListener("input", handleFilter);
  });
}

/* 3. Konfirmasi Hapus Baris (.btn-hapus) */
function initHapusConfirm() {
  // Event Delegation pada level document
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    if (!row) return;

    const cells = row.querySelectorAll("td");
    const labelData = cells.length > 2 ? cells[2].textContent.trim() : "data ini";

    const yakin = confirm(`Apakah Anda yakin ingin menghapus data "${labelData}"?`);
    if (yakin) {
      row.remove(); // Hapus elemen dari DOM secara front-end
    }
  });
}

/* 4. Validasi Form Client-Side AbsenUKM */
function initValidasiForm() {
  const forms = document.querySelectorAll("form");

  forms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      let isValid = true;

      // Bersihkan pesan error sebelumnya
      form.querySelectorAll(".pesan-error").forEach(el => el.remove());
      form.querySelectorAll(".input-error").forEach(el => el.classList.remove("input-error"));

      // === A. Validasi Field Wajib Isi (Required) ===
      const requiredInputs = form.querySelectorAll("input[required], select[required], textarea[required]");
      requiredInputs.forEach(function (input) {
        if (input.value.trim() === "") {
          tampilkanErrorInline(input, "Field ini wajib diisi.");
          isValid = false;
        }
      });

      // === B. Validasi NIM Mahasiswa / Anggota UKM ===
      const nimInput = form.querySelector("#nim, [name='nim'], #nim_anggota");
      if (nimInput && nimInput.value.trim() !== "") {
        const valNim = nimInput.value.trim();
        if (!/^\d+$/.test(valNim)) {
          tampilkanErrorInline(nimInput, "NIM harus berupa digit angka.");
          isValid = false;
        } else if (valNim.length < 8 || valNim.length > 15) {
          tampilkanErrorInline(nimInput, "NIM harus bernilai 8 hingga 15 digit.");
          isValid = false;
        }
      }

      // === C. Validasi Poin Kehadiran / Kuota Peserta (Non-Negatif) ===
      const poinInput = form.querySelector("#poin, [name='poin'], #kuota, [name='kuota']");
      if (poinInput && poinInput.value.trim() !== "") {
        const valPoin = parseInt(poinInput.value.trim(), 10);
        if (isNaN(valPoin)) {
          tampilkanErrorInline(poinInput, "Nilai harus berupa angka.");
          isValid = false;
        } else if (valPoin < 0) {
          tampilkanErrorInline(poinInput, "Nilai tidak boleh negatif.");
          isValid = false;
        }
      }

      // === D. Validasi Tanggal Absensi / Kegiatan ===
      const tglInput = form.querySelector("#tanggal, [name='tanggal'], #tgl_kegiatan");
      if (tglInput && tglInput.value.trim() === "" && tglInput.hasAttribute("required")) {
        tampilkanErrorInline(tglInput, "Tanggal kegiatan wajib dipilih.");
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  });
}

/**
 * Menampilkan pesan error inline tepat di bawah elemen input menggunakan insertAdjacentElement
 */
function tampilkanErrorInline(inputEl, pesan) {
  inputEl.classList.add("input-error");

  const errSpan = document.createElement("span");
  errSpan.className = "pesan-error";
  errSpan.textContent = pesan;

  // Implementasi eksplisit insertAdjacentElement sesuai perintah Jobsheet 5
  inputEl.insertAdjacentElement("afterend", errSpan);
}