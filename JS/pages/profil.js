document.addEventListener('DOMContentLoaded', () => {
    const formUpdateProfil = document.getElementById('formUpdateProfil');
    const toastNotif = document.getElementById('toastNotif');

    if (formUpdateProfil) {
        formUpdateProfil.addEventListener('submit', function(e) {
            e.preventDefault(); 
            let isValid = true;
            
            // Validasi Email
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

            // Validasi Password Baru & Konfirmasi
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
                // Reset error jika dikosongkan
                newPassInput.classList.remove('is-invalid');
                confPassInput.classList.remove('is-invalid');
                passLengthError.style.display = 'none';
                passMatchError.style.display = 'none';
            }

            // Jika semua valid, tampilkan Toast Sukses
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
});