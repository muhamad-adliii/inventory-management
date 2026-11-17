document.addEventListener('DOMContentLoaded', function () {
    const selectTransaksi = document.getElementById('selectTransaksi');
    const areaDetail = document.getElementById('areaDetail');
    const tbodyDetail = document.getElementById('tbodyDetail');

    selectTransaksi.addEventListener('change', async function () {
        const id = this.value;
        
        if (!id) {
            areaDetail.classList.add('hidden');
            tbodyDetail.innerHTML = '';
            return;
        }

        // Tampilkan Loading
        areaDetail.classList.remove('hidden');
        tbodyDetail.innerHTML = `<tr><td colspan="3" class="text-center py-4">Memuat data transaksi...</td></tr>`;

        try {
            // Fetch data dari controller
            const response = await fetch(`/retur/transaksi/${id}`);
            if (!response.ok) throw new Error('Gagal mengambil data');
            
            const data = await response.json();

            // Isi Info Header
            document.getElementById('detailSupplier').textContent = ': ' + (data.supplier ? data.supplier.nama_supplier : '-');
            document.getElementById('detailPetugas').textContent = ': ' + (data.akun ? data.akun.username : '-'); // sesuaikan nama kolom akun
            document.getElementById('detailTanggal').textContent = ': ' + new Date(data.tanggal).toLocaleDateString('id-ID');

            // Isi Tabel Produk
            tbodyDetail.innerHTML = '';
            
            // Loop produk dari detail transaksi masuk
            data.detail_transaksi_masuk.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-100';
                tr.innerHTML = `
                    <td class="py-3 px-2 font-medium">${item.produk.nama_produk}</td>
                    <td class="py-3 px-2">${item.jumlah_barang} ${item.produk.satuan}</td>
                    <td class="py-3 px-2 w-32">
                        <!-- Hidden input ID Produk -->
                        <input type="hidden" name="id_produk[]" value="${item.id_produk}">
                        <!-- Input Jumlah Retur (max: qty masuk) -->
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
});