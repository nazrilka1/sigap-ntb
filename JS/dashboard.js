document.addEventListener('DOMContentLoaded', () => {
    // --- 1. Sidebar Logic ---
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

    // --- 2. Table Slider & Pagination (Updated) ---
    const sliderTrack = document.getElementById('sliderTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const tableInfo = document.getElementById('tableInfo');
    
    let currentSlideIndex = 0;
    // Hitung jumlah slide secara dinamis
    const tableSlides = document.querySelectorAll('.table-slide');
    const totalSlides = tableSlides.length;

    // Fungsi untuk memperbarui status tombol (disabled/enabled)
    function updateArrowStatus() {
        if (!prevBtn || !nextBtn) return;

        // Jika di slide pertama, disable tombol prev
        if (currentSlideIndex === 0) {
            prevBtn.classList.add('disabled');
            prevBtn.setAttribute('disabled', 'true');
        } else {
            prevBtn.classList.remove('disabled');
            prevBtn.removeAttribute('disabled');
        }

        // Jika di slide terakhir, disable tombol next
        if (currentSlideIndex === totalSlides - 1) {
            nextBtn.classList.add('disabled');
            nextBtn.setAttribute('disabled', 'true');
        } else {
            nextBtn.classList.remove('disabled');
            nextBtn.removeAttribute('disabled');
        }
    }

    window.goToSlide = function(index) {
        // Validasi index
        if (index < 0 || index >= totalSlides || !sliderTrack) return;
        
        // Gerakkan slider
        sliderTrack.style.transform = `translateX(-${index * 100}%)`;
        currentSlideIndex = index;
        
        // Perbarui status tombol kiri/kanan
        updateArrowStatus();

        // Perbarui text info (opsional, sesuaikan logika item per slide jika perlu)
        const itemsPerSlide = 4; // Asumsi item per slide
        const startItem = (index * itemsPerSlide) + 1;
        // Ini hanya dummy info, sesuaikan dengan total data asli jika ada backend
        const dummyTotalData = 1284; 
        const endItem = Math.min((index + 1) * itemsPerSlide, dummyTotalData);
        
        if(tableInfo) tableInfo.textContent = `Menampilkan ${startItem}-${endItem} dari ${dummyTotalData.toLocaleString('id-ID')} laporan`;
    };

    // Event Listeners tombol kiri/kanan
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (!prevBtn.classList.contains('disabled')) {
                goToSlide(currentSlideIndex - 1);
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (!nextBtn.classList.contains('disabled')) {
                goToSlide(currentSlideIndex + 1);
            }
        });
    }

    // Inisialisasi status tombol saat pertama kali dimuat
    updateArrowStatus();

    // --- 3. Live Search ---
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filterValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table-row');
            tableRows.forEach(row => {
                row.textContent.toLowerCase().includes(filterValue) ? row.style.display = '' : row.style.display = 'none';
            });
            // Reset ke slide 0 jika search kosong
            if (filterValue === '') goToSlide(0);
        });
    }

    console.log("Dashboard Admin NTB Loaded with fixed navigation.");
});