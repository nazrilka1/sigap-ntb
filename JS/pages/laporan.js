// =========================================
// LOGIKA HALAMAN KELOLA LAPORAN & DASHBOARD
// Fitur: Filter Multi-Layer & Live Search
// =========================================

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const kategoriFilter = document.getElementById('kategoriFilter');
    const dateFilter = document.getElementById('dateFilter');

    function applyFilters() {
        // Ambil nilai dari setiap input filter (jika elemennya ada)
        const searchVal = searchInput ? searchInput.value.toLowerCase() : '';
        const statusVal = statusFilter ? statusFilter.value.toLowerCase() : '';
        const kategoriVal = kategoriFilter ? kategoriFilter.value.toLowerCase() : '';
        const dateVal = dateFilter ? dateFilter.value : '';

        // Ambil semua baris tabel laporan (abaikan baris user jika tabelnya gabung)
        const tableRows = document.querySelectorAll('.table-row:not(.user-row)');

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = row.getAttribute('data-status') ? row.getAttribute('data-status').toLowerCase() : '';
            const rowKategori = row.getAttribute('data-kategori') ? row.getAttribute('data-kategori').toLowerCase() : '';
            
            const rowDateEl = row.querySelector('.row-date');
            const rowDate = rowDateEl ? rowDateEl.textContent.trim() : '';

            // Cek kecocokan data
            const matchSearch = rowText.includes(searchVal);
            const matchStatus = statusVal === '' || rowStatus === statusVal;
            const matchKategori = kategoriVal === '' || rowKategori === kategoriVal;
            const matchDate = dateVal === '' || rowDate.includes(dateVal);

            // Tampilkan baris jika SEMUA filter cocok
            if (matchSearch && matchStatus && matchKategori && matchDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Pasang Event Listener jika elemen input ditemukan di halaman tersebut
    if (searchInput) searchInput.addEventListener('keyup', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    if (kategoriFilter) kategoriFilter.addEventListener('change', applyFilters);
    if (dateFilter) dateFilter.addEventListener('change', applyFilters);
});