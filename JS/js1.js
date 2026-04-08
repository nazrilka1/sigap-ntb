// Mengambil elemen tombol bar dan menu navigasi
const bar = document.querySelector('.bar');
const navbar = document.querySelector('.navbar');

// Menambahkan event listener klik
bar.addEventListener('click', function() {
    // Menambah/menghapus class 'active' pada navbar
    navbar.classList.toggle('active');
    
    // Menambah/menghapus class 'toggle' pada tombol bar (animasi X)
    bar.classList.toggle('toggle');
});

// Menutup sidebar jika pengguna mengklik di luar sidebar
document.addEventListener('click', function(e) {
    if (!bar.contains(e.target) && !navbar.contains(e.target)) {
        navbar.classList.remove('active');
        bar.classList.remove('toggle');
    }
});