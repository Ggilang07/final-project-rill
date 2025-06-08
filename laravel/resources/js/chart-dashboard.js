document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('suratChart')?.getContext('2d');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Total', 'Disetujui', 'Menunggu', 'Ditolak', 'Dibatalkan'],
            datasets: [{
                label: 'Jumlah Surat',
                data: window.chartData || [0, 0, 0, 0, 0],
                fill: false,
                borderColor: '#3B82F6',
                backgroundColor: '#3B82F6',
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
});
