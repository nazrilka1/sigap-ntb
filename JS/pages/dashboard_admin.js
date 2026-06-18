document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('chartsContainer');
    
    // Hentikan eksekusi jika elemen tidak ditemukan
    if (!container) return;

    // Ambil data dari atribut HTML yang sudah disiapkan oleh PHP
    const dataTotal = parseInt(container.getAttribute('data-total')) || 0;
    const dataMenunggu = parseInt(container.getAttribute('data-menunggu')) || 0;
    const dataSelesai = parseInt(container.getAttribute('data-selesai')) || 0;

    const labelsData = ['Total Laporan', 'Menunggu', 'Selesai'];
    const valuesData = [dataTotal, dataMenunggu, dataSelesai];
    const chartColors = ['#2563eb', '#d97706', '#16a34a']; 

    // 1. Inisialisasi Grafik Batang
    const barCanvas = document.getElementById('barChart');
    if (barCanvas) {
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Jumlah Data',
                    data: valuesData,
                    backgroundColor: chartColors,
                    borderRadius: 5
                }]
            },
            options: { 
                responsive: true,
                aspectRatio: 1, 
                plugins: { legend: { display: false } } 
            }
        });
    }

    // 2. Inisialisasi Grafik Lingkaran
    const pieCanvas = document.getElementById('pieChart');
    if (pieCanvas) {
        new Chart(pieCanvas, {
            type: 'pie',
            data: {
                labels: labelsData,
                datasets: [{
                    data: valuesData,
                    backgroundColor: chartColors
                }]
            },
            options: { 
                responsive: true 
            }
        });
    }

    // 3. Inisialisasi Grafik Garis
    const lineCanvas = document.getElementById('lineChart');
    if (lineCanvas) {
        new Chart(lineCanvas, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Perbandingan Jumlah',
                    data: valuesData,
                    borderColor: '#0a2647',
                    tension: 0.3,
                    fill: false,
                    pointBackgroundColor: chartColors,
                    pointBorderColor: '#fff',
                    pointRadius: 6
                }]
            },
            options: { 
                responsive: true,
                aspectRatio: 1, 
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
});