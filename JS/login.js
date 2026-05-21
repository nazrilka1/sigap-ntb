const username = document.getElementById("userlogin");
const password = document.getElementById("passlogin");
const role = document.getElementById("role");

const form = document.getElementById("loginForm");

form.addEventListener('submit', (e) => {

    e.preventDefault();

    if(username.value.trim() === ""){

        Swal.fire({
            title: 'Oops!',
            text: 'Username tidak boleh kosong',
            icon: 'warning',
            confirmButtonText: 'OK'
        });

        return;
    }

    if(password.value.trim() === ""){

        Swal.fire({
            title: 'Oops!',
            text: 'Password tidak boleh kosong',
            icon: 'warning',
            confirmButtonText: 'OK'
        });

        return;
    }

    if(role.value === ""){

        Swal.fire({
            title: 'Oops!',
            text: 'Silakan pilih role',
            icon: 'warning',
            confirmButtonText: 'OK'
        });

        return;
    }

    Swal.fire({
        title: 'Berhasil!',
        text: 'Login berhasil',
        icon: 'success',
        confirmButtonText: 'Lanjut'
    });

});