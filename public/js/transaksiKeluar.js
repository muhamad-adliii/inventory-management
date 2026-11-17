document.addEventListener("DOMContentLoaded", function () {
    const inProduk = document.getElementById("inProdukKeluar");
    const inQty = document.getElementById("inQtyKeluar");
    const inHarga = document.getElementById("inHargaKeluar");
    const inStok = document.getElementById("inStokKeluar");
    const btnTambah = document.getElementById("btnTambahKeluar");
    const bodyItem = document.getElementById("bodyItemKeluar");
    const grandTotalTxt = document.getElementById("grandTotalKeluar");
    const hiddenInputs = document.getElementById("hiddenInputsKeluar");
    const pesanBaris = document.getElementById("pesanBarisKeluar");

    let items = [];

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

    // Auto-fill Harga & Stok
    inProduk.addEventListener("change", function () {
        const opt = this.options[this.selectedIndex];
        inHarga.value = opt.getAttribute("data-harga") || "";
        inStok.value = opt.getAttribute("data-stok") || "";

        if (this.value) inQty.focus();
    });

    btnTambah.addEventListener("click", function () {
        const produkId = inProduk.value;
        const namaProduk = inProduk.options[inProduk.selectedIndex].text;
        const qty = parseInt(inQty.value);
        const harga = parseFloat(inHarga.value);
        const stokTersedia = parseInt(inStok.value);

        if (!produkId || !qty || qty < 1 || isNaN(harga)) {
            pesanBaris.textContent =
                "Lengkapi data produk dan qty dengan benar.";
            pesanBaris.classList.remove("hidden");
            return;
        }

        // Validasi Stok di JS
        const existingIndex = items.findIndex((i) => i.id_produk === produkId);
        const currentQtyInTable =
            existingIndex !== -1 ? items[existingIndex].qty : 0;

        if (qty + currentQtyInTable > stokTersedia) {
            pesanBaris.textContent = `Stok tidak cukup! Sisa stok: ${stokTersedia}`;
            pesanBaris.classList.remove("hidden");
            return;
        }

        pesanBaris.classList.add("hidden");

        if (existingIndex !== -1) {
            items[existingIndex].qty += qty;
        } else {
            items.push({
                id_produk: produkId,
                nama_produk: namaProduk,
                qty: qty,
                harga: harga,
            });
        }

        inProduk.value = "";
        inQty.value = "";
        inHarga.value = "";
        inStok.value = "";
        renderTable();
    });

    function renderTable() {
        bodyItem.innerHTML = "";
        hiddenInputs.innerHTML = "";
        let grandTotal = 0;

        if (items.length === 0) {
            bodyItem.innerHTML = `<tr><td colspan="6" class="py-4 text-center text-gray-500 border-b border-gray-100">Tidak ada data produk</td></tr>`;
            grandTotalTxt.textContent = "0";
            return;
        }

        items.forEach((item, index) => {
            const subtotal = item.qty * item.harga;
            grandTotal += subtotal;

            const tr = document.createElement("tr");
            tr.className = "border-b border-gray-100";
            tr.innerHTML = `
                <td class="py-3 px-2">${index + 1}</td>
                <td class="py-3 px-2 font-medium">${item.nama_produk}</td>
                <td class="py-3 px-2">${item.qty}</td>
                <td class="py-3 px-2">Rp. ${formatRupiah(item.harga)}</td>
                <td class="py-3 px-2">Rp. ${formatRupiah(subtotal)}</td>
                <td class="py-3 px-2">
                    <button type="button" class="text-red-500 font-medium text-xs" onclick="hapusItemKeluar(${index})">Hapus</button>
                </td>
            `;
            bodyItem.appendChild(tr);

            hiddenInputs.innerHTML += `
                <input type="hidden" name="items[${index}][id_produk]" value="${item.id_produk}">
                <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
            `;
        });

        grandTotalTxt.textContent = "Rp. " + formatRupiah(grandTotal);
    }

    window.hapusItemKeluar = function (index) {
        items.splice(index, 1);
        renderTable();
    };

    function formatRupiah(angka) {
        return new Intl.NumberFormat("id-ID").format(angka);
    }
});
