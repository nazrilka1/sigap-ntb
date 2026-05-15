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

    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && sidebar && mobileToggle) {
            if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        }
    });

    // =========================================
    // 2. FILTER MULTI-LAYER & LIVE SEARCH (LAPORAN)
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

        const tableRows = document.querySelectorAll('.table-row:not(.user-row)');

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

    if (searchInput && !document.getElementById('searchUser')) searchInput.addEventListener('keyup', applyFilters);
    if (statusFilter && !document.getElementById('statusUserFilter')) statusFilter.addEventListener('change', applyFilters);
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
    // 4. IMAGE UPLOAD PREVIEW (GLOBAL)
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

    // =========================================
    // 5. UPDATE PROFIL LOGIC
    // =========================================
    const uploadFoto = document.getElementById('uploadFoto');
    const profilePicPreview = document.getElementById('profilePicPreview');
    const headerProfilePic = document.getElementById('headerProfilePic');

    if (uploadFoto && profilePicPreview) {
        uploadFoto.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePicPreview.src = event.target.result;
                    if(headerProfilePic) headerProfilePic.src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    const togglePasswords = document.querySelectorAll('.toggle-password');
    togglePasswords.forEach(icon => {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const inputEl = document.getElementById(targetId);
            
            if (inputEl.type === 'password') {
                inputEl.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                inputEl.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

    const formUpdateProfil = document.getElementById('formUpdateProfil');
    const toastNotif = document.getElementById('toastNotif');

    if (formUpdateProfil) {
        formUpdateProfil.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            let isValid = true;
            
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailPattern.test(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                emailError.style.display = 'block';
                isValid = false;
            } else {
                emailInput.classList.remove('is-invalid');
                emailError.style.display = 'none';
            }

            const newPassInput = document.getElementById('newPassword');
            const confPassInput = document.getElementById('confirmPassword');
            const passLengthError = document.getElementById('passLengthError');
            const passMatchError = document.getElementById('passMatchError');

            if (newPassInput.value.length > 0) {
                if (newPassInput.value.length < 8) {
                    newPassInput.classList.add('is-invalid');
                    passLengthError.style.display = 'block';
                    isValid = false;
                } else {
                    newPassInput.classList.remove('is-invalid');
                    passLengthError.style.display = 'none';
                }

                if (newPassInput.value !== confPassInput.value) {
                    confPassInput.classList.add('is-invalid');
                    passMatchError.style.display = 'block';
                    isValid = false;
                } else {
                    confPassInput.classList.remove('is-invalid');
                    passMatchError.style.display = 'none';
                }
            } else {
                newPassInput.classList.remove('is-invalid');
                confPassInput.classList.remove('is-invalid');
                passLengthError.style.display = 'none';
                passMatchError.style.display = 'none';
            }

            if (isValid) {
                document.getElementById('oldPassword').value = '';
                newPassInput.value = '';
                confPassInput.value = '';
                
                toastNotif.classList.add('show');
                setTimeout(() => {
                    toastNotif.classList.remove('show');
                }, 3000);
            }
        });
    }

    // =========================================
    // 6. MANAJEMEN USER LOGIC
    // =========================================
    const searchUser = document.getElementById('searchUser');
    const roleUserFilter = document.getElementById('roleUserFilter');
    const statusUserFilter = document.getElementById('statusUserFilter');

    function applyUserFilters() {
        const searchVal = searchUser ? searchUser.value.toLowerCase() : '';
        const roleVal = roleUserFilter ? roleUserFilter.value.toLowerCase() : '';
        const statusVal = statusUserFilter ? statusUserFilter.value.toLowerCase() : '';

        const userRows = document.querySelectorAll('.user-row');

        userRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowRole = row.getAttribute('data-role') ? row.getAttribute('data-role').toLowerCase() : '';
            const rowStatus = row.getAttribute('data-status') ? row.getAttribute('data-status').toLowerCase() : '';

            const matchSearch = rowText.includes(searchVal);
            const matchRole = roleVal === '' || rowRole === roleVal;
            const matchStatus = statusVal === '' || rowStatus === statusVal;

            if (matchSearch && matchRole && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchUser) searchUser.addEventListener('keyup', applyUserFilters);
    if (roleUserFilter) roleUserFilter.addEventListener('change', applyUserFilters);
    if (statusUserFilter) statusUserFilter.addEventListener('change', applyUserFilters);

    const userFormModal = document.getElementById('userFormModal');
    const userModalTitle = document.getElementById('userModalTitle');

    window.openUserModal = function(mode) {
        if (userFormModal) {
            if(mode === 'add') {
                userModalTitle.textContent = "Tambah User Baru";
                document.getElementById('formUserData').reset();
                document.getElementById('modalUserPic').src = "https://via.placeholder.com/100";
            } else if(mode === 'edit') {
                userModalTitle.textContent = "Edit Data User";
            }
            
            userFormModal.classList.add('active');
            document.body.style.overflow = 'hidden'; 
        }
    };

    window.closeUserModal = function() {
        if (userFormModal) {
            userFormModal.classList.remove('active');
            document.body.style.overflow = 'auto'; 
        }
    };

    const deleteConfirmModal = document.getElementById('deleteConfirmModal');

    window.openDeleteModal = function() {
        if (deleteConfirmModal) {
            deleteConfirmModal.classList.add('active');
            document.body.style.overflow = 'hidden'; 
        }
    };

    window.closeDeleteModal = function() {
        if (deleteConfirmModal) {
            deleteConfirmModal.classList.remove('active');
            document.body.style.overflow = 'auto'; 
        }
    };

    if (userFormModal) {
        userFormModal.addEventListener('click', (e) => {
            if (e.target === userFormModal) closeUserModal();
        });
    }
    
    if (deleteConfirmModal) {
        deleteConfirmModal.addEventListener('click', (e) => {
            if (e.target === deleteConfirmModal) closeDeleteModal();
        });
    }

});