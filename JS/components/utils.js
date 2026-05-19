// 1. Fungsi Global Preview Gambar
window.previewImage = function(input, imgId) {
    const previewEl = document.getElementById(imgId);
    if (input.files && input.files[0] && previewEl) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewEl.src = e.target.result;
            previewEl.style.opacity = '1';
            
            const headerProfilePic = document.getElementById('headerProfilePic');
            if(headerProfilePic && imgId === 'profilePicPreview') {
                headerProfilePic.src = e.target.result;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
};

// 2. Fungsi Toggle Lihat/Sembunyi Password
document.addEventListener('DOMContentLoaded', () => {
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
});

// 3. Fungsi Global Menampilkan Toast Notifikasi (BARU)
window.showToast = function(toastId = 'toastNotif') {
    // Mencari elemen berdasarkan ID yang diberikan (default: 'toastNotif')
    const toast = document.getElementById(toastId);
    if(toast) {
        toast.classList.add('show');
        
        // Sembunyikan otomatis setelah 3 detik
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
};