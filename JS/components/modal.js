// Fungsi bantuan internal untuk membuka/menutup modal apapun
function toggleModalStatus(modalId, action) {
    const modal = document.getElementById(modalId);
    if (modal) {
        if (action === 'open') {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Kunci scroll
        } else {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto'; // Buka scroll
        }
    }
}

// 1. Trigger Modal Laporan
window.openModal = function(reportId) {
    const modalReportId = document.getElementById('modalReportId');
    if (modalReportId) modalReportId.textContent = '#' + reportId;
    toggleModalStatus('detailModal', 'open');
};
window.closeModal = function() {
    toggleModalStatus('detailModal', 'close');
    // Reset preview gambar laporan saat modal ditutup
    document.querySelectorAll('#detailModal .upload-preview').forEach(img => { 
        img.src = ''; img.style.opacity = '0'; 
    });
};

// 2. Trigger Modal Manajemen User (Tambah/Edit)
window.openUserModal = function(mode) {
    const userModalTitle = document.getElementById('userModalTitle');
    if (mode === 'add' && userModalTitle) {
        userModalTitle.textContent = "Tambah User Baru";
        document.getElementById('formUserData').reset();
        document.getElementById('modalUserPic').src = "https://via.placeholder.com/100";
    } else if(mode === 'edit' && userModalTitle) {
        userModalTitle.textContent = "Edit Data User";
    }
    toggleModalStatus('userFormModal', 'open');
};
window.closeUserModal = function() { toggleModalStatus('userFormModal', 'close'); };

// 3. Trigger Modal Konfirmasi Hapus
window.openDeleteModal = function() { toggleModalStatus('deleteConfirmModal', 'open'); };
window.closeDeleteModal = function() { toggleModalStatus('deleteConfirmModal', 'close'); };

// 4. Fitur Pintar: Tutup modal apapun jika area gelap (overlay) diklik
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    });
});