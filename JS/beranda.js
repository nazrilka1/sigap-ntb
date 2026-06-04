// Menunggu DOM selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
    
    const navbar = document.querySelector('.navbar');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');

    // 1. Efek Navbar Sticky (Tetap saat discroll)
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled'); // Tambah background biru saat turun
        } else {
            navbar.classList.remove('scrolled'); // Hapus background saat di paling atas
        }
    });

    // 2. Toggle Mobile Menu
    if(mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            
            const icon = mobileMenuBtn.querySelector('i');
            if(navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
                // Paksa navbar menjadi solid saat menu mobile terbuka agar tidak transparan
                navbar.classList.add('scrolled'); 
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                // Kembalikan ke transparan jika scroll masih di atas
                if(window.scrollY <= 50) {
                    navbar.classList.remove('scrolled');
                }
            }
        });
    }

});