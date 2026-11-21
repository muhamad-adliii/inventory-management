document.addEventListener('DOMContentLoaded', function () {
    const btnTambah = document.getElementById('btnTambah');
    const inProduk  = document.getElementById('inProduk');
    const inQty     = document.getElementById('inQty');
    const inHarga   = document.getElementById('inHarga');
    const bodyItem  = document.getElementById('bodyItem');
    const grandTotalTxt = document.getElementById('grandTotal');
    const hiddenInputs  = document.getElementById('hiddenInputs');
    const pesanBaris    = document.getElementById('pesanBaris');
    
    const tombol = document.querySelectorAll("[data-tab]");
    const halaman = document.querySelectorAll(".tab-section");

    tombol.forEach((btn) => {
        btn.addEventListener("click", () => {
            const tujuan = btn.dataset.tab;

            halaman.forEach((h) =>
                h.classList.toggle("hidden", h.id !== tujuan)
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

    // ==========================================
    // 2. FITUR AUTO-FILL HARGA & TAMBAH BARANG
    // ==========================================
    let items = []; // Array untuk menyimpan data sementara

    inProduk.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const hargaDariDb = selectedOption.getAttribute('data-harga');

        if (hargaDariDb) {
            inHarga.value = parseFloat(hargaDariDb);
        } else {
            inHarga.value = '';
        }
        
        if (this.value) {
            inQty.focus(); 
        }
    });

    btnTambah.addEventListener('click', function () {
        const produkId = inProduk.value;
        const produkText = inProduk.options[inProduk.selectedIndex].text;
        const qty = parseInt(inQty.value);
        const harga = parseFloat(inHarga.value);

        if (!produkId || !qty || qty < 1 || isNaN(harga) || harga < 0) {
            pesanBaris.textContent = "Mohon lengkapi data produk, qty (min 1), dan harga dengan benar.";
            pesanBaris.classList.remove('hidden');
            return;
        }

        pesanBaris.classList.add('hidden');

        const existingIndex = items.findIndex(item => item.id_produk === produkId);
        if (existingIndex !== -1) {
            items[existingIndex].qty += qty;
            items[existingIndex].harga = harga; 
        } else {
            items.push({
                id_produk: produkId,
                nama_produk: produkText,
                qty: qty,
                harga: harga
            });
        }

        // Reset input form baris
        inProduk.value = '';
        inQty.value = '';
        inHarga.value = '';

        renderTable();
    });

    function renderTable() {
        bodyItem.innerHTML = '';
        hiddenInputs.innerHTML = '';
        let grandTotal = 0;

        if (items.length === 0) {
            bodyItem.innerHTML = `<tr><td colspan="6" class="py-4 text-center text-gray-500 border-b border-gray-100">Tidak ada data produk</td></tr>`;
            grandTotalTxt.textContent = 'Rp. 0';
            return;
        }

        items.forEach((item, index) => {
            const subtotal = item.qty * item.harga;
            grandTotal += subtotal;

            const tr = document.createElement('tr');
            tr.className = "border-b border-gray-100";
            tr.innerHTML = `
                <td class="py-3 px-2">${index + 1}</td>
                <td class="py-3 px-2 font-medium">${item.nama_produk}</td>
                <td class="py-3 px-2">${item.qty}</td>
                <td class="py-3 px-2">Rp. ${formatRupiah(item.harga)}</td>
                <td class="py-3 px-2">Rp. ${formatRupiah(subtotal)}</td>
                <td class="py-3 px-2">
                    <button type="button" class="text-red-500 hover:text-red-700 font-medium text-xs" onclick="hapusItem(${index})">Hapus</button>
                </td>
            `;
            bodyItem.appendChild(tr);

            hiddenInputs.innerHTML += `
                <input type="hidden" name="items[${index}][id_produk]" value="${item.id_produk}">
                <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
            `;
        });

        grandTotalTxt.textContent = 'Rp. ' + formatRupiah(grandTotal);
    }

    window.hapusItem = function(index) {
        items.splice(index, 1);
        renderTable();
    };

    // ==========================================
    // 3. FITUR DETAIL TRANSAKSI (AJAX FETCH)
    // ==========================================
    const btnDetails = document.querySelectorAll('.btn-detail');
    const detailTbody = document.getElementById('detailTbody');
    
    btnDetails.forEach(btn => {
        btn.addEventListener('click', async function() {
            const idTransaksi = this.getAttribute('data-id');
            
            // Tampilkan loading sementara
            document.getElementById('detailId').textContent = '#' + idTransaksi;
            if (detailTbody) {
                detailTbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-gray-500">Memuat data...</td></tr>`;
            }

            try {
                // Fetch data dari API / Controller
                // Pastikan route '/barang-masuk/{id}/detail' sudah dibuat di web.php
                const response = await fetch(`/barang-masuk/${idTransaksi}/detail`);
                if (!response.ok) throw new Error('Gagal mengambil data');
                
                const data = await response.json();

                // Isi Info Transaksi
                let totalKeseluruhan = 0;
                let jumlahBarang = 0;

                // Sesuaikan properti object di bawah ini dengan response JSON dari controller lo
                const supplierName = data.supplier ? data.supplier.nama_supplier : '-';
                const petugasName = data.akun ? (data.akun.nama_akun || data.akun.nama) : '-';
                
                document.getElementById('detailSupplier').textContent = ': ' + supplierName;
                document.getElementById('detailPetugas').textContent = ': ' + petugasName;
                
                // Format tanggal
                const tanggalFormat = new Date(data.tanggal).toLocaleDateString('id-ID', { 
                    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
                });
                document.getElementById('detailTanggal').textContent = ': ' + tanggalFormat;

                // Isi Tabel Detail Barang
                detailTbody.innerHTML = '';
                
                // Loop data detail_transaksi_masuk (sesuaikan nama relasi dengan yang di controller)
                const detailArray = data.detail_transaksi_masuk || data.detailTransaksiMasuk || [];
                
                if(detailArray.length === 0) {
                    detailTbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada detail barang.</td></tr>`;
                } else {
                    detailArray.forEach((item, index) => {
                        totalKeseluruhan += parseFloat(item.sub_total);
                        jumlahBarang += item.jumlah_barang;

                        const tr = document.createElement('tr');
                        tr.className = 'border-b border-gray-100';
                        tr.innerHTML = `
                            <td class="px-4 py-4">${index + 1}</td>
                            <td class="px-4 py-4">${item.produk ? item.produk.nama_produk : 'Produk dihapus'}</td>
                            <td class="px-4 py-4">${item.jumlah_barang} ${item.produk ? item.produk.satuan : ''}</td>
                            <td class="px-4 py-4">Rp. ${formatRupiah(item.harga_satuan)}</td>
                            <td class="px-4 py-4">Rp. ${formatRupiah(item.sub_total)}</td>
                        `;
                        detailTbody.appendChild(tr);
                    });
                }

                // Set total di info transaksi
                document.getElementById('detailJumlah').textContent = ': ' + jumlahBarang + ' pcs'; 
                document.getElementById('detailTotal').textContent = ': Rp. ' + formatRupiah(totalKeseluruhan);

            } catch (error) {
                console.error(error);
                if (detailTbody) {
                    detailTbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-red-500">Gagal memuat detail transaksi.</td></tr>`;
                }
            }
        });
    });

    // Utility Format Rupiah
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }
});


// document.addEventListener('DOMContentLoaded', function () {
//     const btnTambah = document.getElementById('btnTambah');
//     const inProduk  = document.getElementById('inProduk');
//     const inQty     = document.getElementById('inQty');
//     const inHarga   = document.getElementById('inHarga');
//     const bodyItem  = document.getElementById('bodyItem');
//     const grandTotalTxt = document.getElementById('grandTotal');
//     const hiddenInputs  = document.getElementById('hiddenInputs');
//     const pesanBaris    = document.getElementById('pesanBaris');
//     const tombol = document.querySelectorAll("[data-tab]");
//     const halaman = document.querySelectorAll(".tab-section");



//     tombol.forEach((btn) => {
//         btn.addEventListener("click", () => {
//             const tujuan = btn.dataset.tab;

//             halaman.forEach((h) =>
//                 h.classList.toggle("hidden", h.id !== tujuan),
//             );

//             document.querySelectorAll(".border-b-2[data-tab]").forEach((t) => {
//                 const aktif = t.dataset.tab === tujuan;
//                 t.classList.toggle("border-black", aktif);
//                 t.classList.toggle("font-medium", aktif);
//                 t.classList.toggle("border-transparent", !aktif);
//                 t.classList.toggle("text-gray-500", !aktif);
//             });
//         });
//     });
//     let items = []; // Array untuk menyimpan data sementara

//     btnTambah.addEventListener('click', function () {
//         const produkId = inProduk.value;
//         const produkText = inProduk.options[inProduk.selectedIndex].text;
//         const qty = parseInt(inQty.value);
//         const harga = parseFloat(inHarga.value);

//         // Validasi sederhana
//         if (!produkId || !qty || qty < 1 || isNaN(harga) || harga < 0) {
//             pesanBaris.textContent = "Mohon lengkapi data produk, qty (min 1), dan harga dengan benar.";
//             pesanBaris.classList.remove('hidden');
//             return;
//         }

//         pesanBaris.classList.add('hidden');

//         // Cek apakah produk sudah ada di list? (Opsional, untuk mencegah dobel)
//         const existingIndex = items.findIndex(item => item.id_produk === produkId);
//         if (existingIndex !== -1) {
//             // Jika sudah ada, update qty dan harganya saja
//             items[existingIndex].qty += qty;
//             items[existingIndex].harga = harga; // atau items[existingIndex].harga += harga; tergantung bisnis lo
//         } else {
//             // Jika belum ada, push data baru
//             items.push({
//                 id_produk: produkId,
//                 nama_produk: produkText,
//                 qty: qty,
//                 harga: harga
//             });
//         }

//         // Reset input form baris
//         inProduk.value = '';
//         inQty.value = '';
//         inHarga.value = '';

//         renderTable();
//     });
//     inProduk.addEventListener('change', function() {
//            const selectedOption = this.options[this.selectedIndex];
//            const hargaDariDb = selectedOption.getAttribute('data-harga');

//            if (hargaDariDb) {
//                inHarga.value = parseFloat(hargaDariDb); // Set nilai input harga
//            } else {
//                inHarga.value = ''; // Kosongkan kalau pilih "Pilih Produk"
//            }
           
//            // Opsional: Langsung fokus ke Qty setelah pilih produk biar cepet
//            if (this.value) {
//                inQty.focus(); 
//            }
//        });

//     function renderTable() {
//         bodyItem.innerHTML = '';
//         hiddenInputs.innerHTML = '';
//         let grandTotal = 0;

//         if (items.length === 0) {
//             bodyItem.innerHTML = `<tr><td colspan="6" class="py-4 text-center text-gray-500 border-b border-gray-100">Tidak ada data produk</td></tr>`;
//             grandTotalTxt.textContent = 'Rp. 0';
//             return;
//         }

//         items.forEach((item, index) => {
//             const subtotal = item.qty * item.harga;
//             grandTotal += subtotal;

//             // Render baris tabel
//             const tr = document.createElement('tr');
//             tr.className = "border-b border-gray-100";
//             tr.innerHTML = `
//                 <td class="py-3 px-2">${index + 1}</td>
//                 <td class="py-3 px-2 font-medium">${item.nama_produk}</td>
//                 <td class="py-3 px-2">${item.qty}</td>
//                 <td class="py-3 px-2">Rp. ${formatRupiah(item.harga)}</td>
//                 <td class="py-3 px-2">Rp. ${formatRupiah(subtotal)}</td>
//                 <td class="py-3 px-2">
//                     <button type="button" class="text-red-500 hover:text-red-700 font-medium text-xs" onclick="hapusItem(${index})">Hapus</button>
//                 </td>
//             `;
//             bodyItem.appendChild(tr);

//             // Render hidden inputs untuk di-submit ke Controller
//             hiddenInputs.innerHTML += `
//                 <input type="hidden" name="items[${index}][id_produk]" value="${item.id_produk}">
//                 <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
//                 <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
//             `;
//         });

//         grandTotalTxt.textContent = 'Rp. ' + formatRupiah(grandTotal);
//     }

//     // Fungsi hapus item (harus global agar bisa dipanggil dari onclick HTML string)
//     window.hapusItem = function(index) {
//         items.splice(index, 1);
//         renderTable();
//     };

//     function formatRupiah(angka) {
//         return new Intl.NumberFormat('id-ID').format(angka);
//     }
// });






























// document.addEventListener("DOMContentLoaded", () => {
//     const tombol = document.querySelectorAll("[data-tab]");
//     const halaman = document.querySelectorAll(".tab-section");

//     tombol.forEach((btn) => {
//         btn.addEventListener("click", () => {
//             const tujuan = btn.dataset.tab;

//             halaman.forEach((h) =>
//                 h.classList.toggle("hidden", h.id !== tujuan),
//             );

//             document.querySelectorAll(".border-b-2[data-tab]").forEach((t) => {
//                 const aktif = t.dataset.tab === tujuan;
//                 t.classList.toggle("border-black", aktif);
//                 t.classList.toggle("font-medium", aktif);
//                 t.classList.toggle("border-transparent", !aktif);
//                 t.classList.toggle("text-gray-500", !aktif);
//             });
//         });
//     });

//     // ---------- form input ----------
//     const form = document.getElementById("formTransaksi");
//     if (!form) return;

//     const inProduk = document.getElementById("inProduk");
//     const inBatch = document.getElementById("inBatch");
//     const inQty = document.getElementById("inQty");
//     const inHarga = document.getElementById("inHarga");
//     const bodyItem = document.getElementById("bodyItem");
//     const grandTotalEl = document.getElementById("grandTotal");
//     const hidden = document.getElementById("hiddenInputs");
//     const pesan = document.getElementById("pesanBaris");

//     let items = [];
//     const rupiah = (n) => "Rp " + Number(n).toLocaleString("id-ID");
//     const esc = (s) =>
//         String(s)
//             .replace(/&/g, "&amp;")
//             .replace(/"/g, "&quot;")
//             .replace(/</g, "&lt;")
//             .replace(/>/g, "&gt;");

//     function tampilPesan(teks) {
//         pesan.textContent = teks;
//         pesan.classList.toggle("hidden", !teks);
//     }

//     function render() {
//         bodyItem.innerHTML = "";
//         hidden.innerHTML = "";

//         if (items.length === 0) {
//             bodyItem.innerHTML =
//                 '<tr><td colspan="7" class="py-4 text-center text-gray-700 border-b border-gray-100">Tidak ada data produk</td></tr>';
//             grandTotalEl.textContent = "0";
//             return;
//         }

//         let total = 0;
//         items.forEach((it, i) => {
//             const sub = it.qty * it.harga;
//             total += sub;

//             bodyItem.insertAdjacentHTML(
//                 "beforeend",
//                 `
//                 <tr class="border-b border-gray-100">
//                     <td class="py-3 px-2">${i + 1}</td>
//                     <td class="py-3 px-2">${esc(it.nama)}</td>
//                     <td class="py-3 px-2">${esc(it.batch) || "-"}</td>
//                     <td class="py-3 px-2">${it.qty}</td>
//                     <td class="py-3 px-2">${rupiah(it.harga)}</td>
//                     <td class="py-3 px-2">${rupiah(sub)}</td>
//                     <td class="py-3 px-2">
//                         <button type="button" data-hapus="${i}" class="text-red-600 hover:underline cursor-pointer">Hapus</button>
//                     </td>
//                 </tr>`,
//             );

//             hidden.insertAdjacentHTML(
//                 "beforeend",
//                 `
//                 <input type="hidden" name="id_produk[]" value="${esc(it.id)}">
//                 <input type="hidden" name="nomor_batch[]" value="${esc(it.batch)}">
//                 <input type="hidden" name="jumlah[]" value="${it.qty}">
//                 <input type="hidden" name="harga_satuan[]" value="${it.harga}">`,
//             );
//         });

//         grandTotalEl.textContent = rupiah(total);
//     }

//     document.getElementById("btnTambah").addEventListener("click", () => {
//         if (!inProduk.value) return tampilPesan("Pilih produk dulu");
//         const qty = parseInt(inQty.value, 10);
//         const harga = parseFloat(inHarga.value);
//         if (!qty || qty < 1) return tampilPesan("Qty minimal 1");
//         if (isNaN(harga) || harga < 0) return tampilPesan("Harga tidak valid");

//         tampilPesan("");
//         const batch = inBatch.value.trim();
//         const sama = items.find(
//             (it) => it.id === inProduk.value && it.batch === batch,
//         );

//         if (sama) {
//             sama.qty += qty;
//             sama.harga = harga;
//         } else {
//             items.push({
//                 id: inProduk.value,
//                 nama: inProduk.selectedOptions[0].textContent.trim(),
//                 batch,
//                 qty,
//                 harga,
//             });
//         }

//         inProduk.value = "";
//         inBatch.value = "";
//         inQty.value = "";
//         inHarga.value = "";
//         render();
//     });

//     bodyItem.addEventListener("click", (e) => {
//         const idx = e.target.dataset.hapus;
//         if (idx !== undefined) {
//             items.splice(Number(idx), 1);
//             render();
//         }
//     });

//     form.addEventListener("submit", (e) => {
//         if (items.length === 0) {
//             e.preventDefault();
//             tampilPesan("Tambahkan minimal satu produk ke tabel");
//         }
//     });
// });
