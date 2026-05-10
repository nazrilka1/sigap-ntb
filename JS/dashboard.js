document.addEventListener('DOMContentLoaded', () => {

    // =========================================
    // 1. SIDEBAR LOGIC (MOBILE)
    // =========================================
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.getElementById('sidebar');

    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Menutup sidebar jika mengklik area di luar sidebar pada mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && sidebar && mobileToggle) {
            if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        }
    });


    // =========================================
    // 2. FILTER MULTI-LAYER & LIVE SEARCH
    // =========================================
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const kategoriFilter = document.getElementById('kategoriFilter');
    const dateFilter = document.getElementById('dateFilter');

    function applyFilters() {
        const searchVal = searchInput ? searchInput.value.toLowerCase() : '';
        const statusVal = statusFilter ? statusFilter.value.toLowerCase() : '';
        const kategoriVal = kategoriFilter ? kategoriFilter.value.toLowerCase() : '';
        const dateVal = dateFilter ? dateFilter.value : '';

        const tableRows = document.querySelectorAll('.table-row');

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = row.getAttribute('data-status') ? row.getAttribute('data-status').toLowerCase() : '';
            const rowKategori = row.getAttribute('data-kategori') ? row.getAttribute('data-kategori').toLowerCase() : '';
            
            const rowDateEl = row.querySelector('.row-date');
            const rowDate = rowDateEl ? rowDateEl.textContent.trim() : '';

            const matchSearch = rowText.includes(searchVal);
            const matchStatus = statusVal === '' || rowStatus === statusVal;
            const matchKategori = kategoriVal === '' || rowKategori === kategoriVal;
            const matchDate = dateVal === '' || rowDate.includes(dateVal);

            if (matchSearch && matchStatus && matchKategori && matchDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('keyup', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    if (kategoriFilter) kategoriFilter.addEventListener('change', applyFilters);
    if (dateFilter) dateFilter.addEventListener('change', applyFilters);


    // =========================================
    // 3. MODAL POPUP DETAIL LAPORAN
    // =========================================
    const detailModal = document.getElementById('detailModal');
    const modalReportId = document.getElementById('modalReportId');

    window.openModal = function(reportId) {
        if (modalReportId) modalReportId.textContent = '#' + reportId;
        if (detailModal) {
            detailModal.classList.add('active');
            document.body.style.overflow = 'hidden'; 
        }
    };

    window.closeModal = function() {
        if (detailModal) {
            detailModal.classList.remove('active');
            document.body.style.overflow = 'auto'; 
        }
        
        // Reset preview gambar dokumentasi saat modal ditutup
        const previews = document.querySelectorAll('.upload-preview');
        previews.forEach(img => { 
            img.src = ''; 
            img.style.opacity = '0'; 
        });
    };

    if (detailModal) {
        detailModal.addEventListener('click', (e) => {
            if (e.target === detailModal) {
                closeModal();
            }
        });
    }

    // =========================================
    // 4. IMAGE UPLOAD PREVIEW
    // =========================================
    window.previewImage = function(input, imgId) {
        const previewEl = document.getElementById(imgId);
        if (input.files && input.files[0] && previewEl) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewEl.src = e.target.result;
                previewEl.style.opacity = '1';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    };

});