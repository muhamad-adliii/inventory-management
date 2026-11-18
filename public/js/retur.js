document.addEventListener("DOMContentLoaded", function () {
    // ===== TAB =====
    const halaman = document.querySelectorAll(".tab-section");

    document.querySelectorAll("[data-tab]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const tujuan = btn.dataset.tab;
            halaman.forEach((h) =>
                h.classList.toggle("hidden", h.id !== tujuan),
            );

            document.querySelectorAll(".tab-btn").forEach((t) => {
                // saat membuka detail, tab "Data Retur Barang" tetap aktif
                const aktif =
                    t.dataset.tab === tujuan ||
                    (t.dataset.tab === "listSection" &&
                        tujuan.startsWith("detailRetur"));
                t.classList.toggle("border-black", aktif);
                t.classList.toggle("font-medium", aktif);
                t.classList.toggle("border-transparent", !aktif);
                t.classList.toggle("text-gray-500", !aktif);
            });
        });
    });

    // ===== PILIH TRANSAKSI MASUK =====
    const selectTransaksi = document.getElementById("selectTransaksi");
    const areaDetail = document.getElementById("areaDetail");
    const tbodyDetail = document.getElementById("tbodyDetail");

    selectTransaksi.addEventListener("change", async function () {
        const id = this.value;

        if (!id) {
            areaDetail.classList.add("hidden");
            tbodyDetail.innerHTML = "";
            return;
        }

        areaDetail.classList.remove("hidden");
        tbodyDetail.innerHTML = `<tr><td colspan="3" class="text-center py-4">Memuat data transaksi...</td></tr>`;

        try {
            const response = await fetch(`/retur/transaksi/${id}`);
            if (!response.ok) throw new Error("Gagal mengambil data");

            const data = await response.json();

            document.getElementById("detailSupplier").textContent =
                ": " + (data.supplier ? data.supplier.nama_supplier : "-");
            document.getElementById("detailPetugas").textContent =
                ": " + (data.akun ? data.akun.nama : "-");
            document.getElementById("detailTanggal").textContent =
                ": " +
                new Date(data.tanggal)
                    .toLocaleDateString("id-ID", {
                        day: "2-digit",
                        month: "2-digit",
                        year: "numeric",
                    })
                    .replaceAll("/", "-");

            tbodyDetail.innerHTML = "";

            data.detail_transaksi_masuk.forEach((item) => {
                const tr = document.createElement("tr");
                tr.className = "border-b border-gray-100";
                tr.innerHTML = `
                    <td class="py-3 px-2 font-medium">${item.produk.nama_produk}</td>
                    <td class="py-3 px-2">${item.jumlah_barang} ${item.produk.satuan}</td>
                    <td class="py-3 px-2 w-32">
                        <input type="hidden" name="id_produk[]" value="${item.id_produk}">
                        <input type="number" name="jumlah_retur[]" min="0" max="${item.jumlah_barang}" value="0"
                            class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm focus:ring-blue-500">
                    </td>
                `;
                tbodyDetail.appendChild(tr);
            });
        } catch (error) {
            console.error(error);
            tbodyDetail.innerHTML = `<tr><td colspan="3" class="text-center py-4 text-red-500">Gagal memuat detail transaksi.</td></tr>`;
        }
    });

    // ===== MODAL KONFIRMASI APPROVE / REJECT =====
    const modal = document.getElementById("modalKonfirmasi");
    const formKonfirmasi = document.getElementById("formKonfirmasi");
    const judul = document.getElementById("modalJudul");
    const pesan = document.getElementById("modalPesan");
    const status = document.getElementById("modalStatus");
    const btnYa = document.getElementById("btnYa");

    const teks = {
        approved: {
            judul: "Setujui retur?",
            pesan: "Retur akan disetujui. Stok tidak berubah karena sudah dikurangi saat pengajuan.",
            warna: "bg-green-600 hover:bg-green-700",
            tombol: "Ya, Setujui",
        },
        rejected: {
            judul: "Tolak retur?",
            pesan: "Retur akan ditolak dan stok produk dikembalikan.",
            warna: "bg-red-600 hover:bg-red-700",
            tombol: "Ya, Tolak",
        },
    };

    function bukaModal(btn) {
        const t = teks[btn.dataset.aksi];
        formKonfirmasi.action = btn.dataset.url;
        status.value = btn.dataset.aksi;
        judul.textContent = `${t.judul} (${btn.dataset.id})`;
        pesan.textContent = t.pesan;
        btnYa.textContent = t.tombol;
        btnYa.className =
            "px-4 py-2 text-sm rounded-md text-white cursor-pointer " + t.warna;
        btnYa.disabled = false;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function tutupModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    document.querySelectorAll(".btn-aksi-retur").forEach((btn) => {
        btn.addEventListener("click", () => bukaModal(btn));
    });
    document.getElementById("btnBatal").addEventListener("click", tutupModal);
    modal.addEventListener("click", (e) => {
        if (e.target === modal) tutupModal();
    });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") tutupModal();
    });
    formKonfirmasi.addEventListener("submit", () => {
        btnYa.disabled = true;
    });
});
