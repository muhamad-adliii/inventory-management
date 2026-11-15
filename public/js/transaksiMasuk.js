document.addEventListener("DOMContentLoaded", () => {
    const tombol = document.querySelectorAll("[data-tab]");
    const halaman = document.querySelectorAll(".tab-section");

    tombol.forEach((btn) => {
        btn.addEventListener("click", () => {
            const tujuan = btn.dataset.tab;

            halaman.forEach((h) =>
                h.classList.toggle("hidden", h.id !== tujuan),
            );

            document.querySelectorAll(".border-b-2[data-tab]").forEach((t) => {
                const aktif = t.dataset.tab === tujuan;
                t.classList.toggle("border-black", aktif);
                t.classList.toggle("font-medium", aktif);
                t.classList.toggle("border-transparent", !aktif);
                t.classList.toggle("text-gray-500", !aktif);
            });
        });
    });

    // ---------- form input ----------
    const form = document.getElementById("formTransaksi");
    if (!form) return;

    const inProduk = document.getElementById("inProduk");
    const inBatch = document.getElementById("inBatch");
    const inQty = document.getElementById("inQty");
    const inHarga = document.getElementById("inHarga");
    const bodyItem = document.getElementById("bodyItem");
    const grandTotalEl = document.getElementById("grandTotal");
    const hidden = document.getElementById("hiddenInputs");
    const pesan = document.getElementById("pesanBaris");

    let items = [];
    const rupiah = (n) => "Rp " + Number(n).toLocaleString("id-ID");
    const esc = (s) =>
        String(s)
            .replace(/&/g, "&amp;")
            .replace(/"/g, "&quot;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");

    function tampilPesan(teks) {
        pesan.textContent = teks;
        pesan.classList.toggle("hidden", !teks);
    }

    function render() {
        bodyItem.innerHTML = "";
        hidden.innerHTML = "";

        if (items.length === 0) {
            bodyItem.innerHTML =
                '<tr><td colspan="7" class="py-4 text-center text-gray-700 border-b border-gray-100">Tidak ada data produk</td></tr>';
            grandTotalEl.textContent = "0";
            return;
        }

        let total = 0;
        items.forEach((it, i) => {
            const sub = it.qty * it.harga;
            total += sub;

            bodyItem.insertAdjacentHTML(
                "beforeend",
                `
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-2">${i + 1}</td>
                    <td class="py-3 px-2">${esc(it.nama)}</td>
                    <td class="py-3 px-2">${esc(it.batch) || "-"}</td>
                    <td class="py-3 px-2">${it.qty}</td>
                    <td class="py-3 px-2">${rupiah(it.harga)}</td>
                    <td class="py-3 px-2">${rupiah(sub)}</td>
                    <td class="py-3 px-2">
                        <button type="button" data-hapus="${i}" class="text-red-600 hover:underline cursor-pointer">Hapus</button>
                    </td>
                </tr>`,
            );

            hidden.insertAdjacentHTML(
                "beforeend",
                `
                <input type="hidden" name="id_produk[]" value="${esc(it.id)}">
                <input type="hidden" name="nomor_batch[]" value="${esc(it.batch)}">
                <input type="hidden" name="jumlah[]" value="${it.qty}">
                <input type="hidden" name="harga_satuan[]" value="${it.harga}">`,
            );
        });

        grandTotalEl.textContent = rupiah(total);
    }

    document.getElementById("btnTambah").addEventListener("click", () => {
        if (!inProduk.value) return tampilPesan("Pilih produk dulu");
        const qty = parseInt(inQty.value, 10);
        const harga = parseFloat(inHarga.value);
        if (!qty || qty < 1) return tampilPesan("Qty minimal 1");
        if (isNaN(harga) || harga < 0) return tampilPesan("Harga tidak valid");

        tampilPesan("");
        const batch = inBatch.value.trim();
        const sama = items.find(
            (it) => it.id === inProduk.value && it.batch === batch,
        );

        if (sama) {
            sama.qty += qty;
            sama.harga = harga;
        } else {
            items.push({
                id: inProduk.value,
                nama: inProduk.selectedOptions[0].textContent.trim(),
                batch,
                qty,
                harga,
            });
        }

        inProduk.value = "";
        inBatch.value = "";
        inQty.value = "";
        inHarga.value = "";
        render();
    });

    bodyItem.addEventListener("click", (e) => {
        const idx = e.target.dataset.hapus;
        if (idx !== undefined) {
            items.splice(Number(idx), 1);
            render();
        }
    });

    form.addEventListener("submit", (e) => {
        if (items.length === 0) {
            e.preventDefault();
            tampilPesan("Tambahkan minimal satu produk ke tabel");
        }
    });
});
