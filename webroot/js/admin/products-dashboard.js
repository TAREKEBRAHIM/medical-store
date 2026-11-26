document.addEventListener('DOMContentLoaded', function() {
    const categoryCanvas = document.getElementById('categoryChart');

    if (categoryCanvas) {
        new Chart(categoryCanvas, {
            type: 'doughnut',
            data: {
                labels: JSON.parse(categoryCanvas.dataset.labels),
                datasets: [{
                    data: JSON.parse(categoryCanvas.dataset.values),
                    backgroundColor: [
                        '#8b6b4a',
                        '#c5a77d',
                        '#a3a083',
                        '#d8c6a5',
                        '#6f8b80',
                        '#b58b8b'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    const statusCanvas = document.getElementById('statusChart');

    if (statusCanvas) {
        new Chart(statusCanvas, {
            type: 'bar',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    label: 'Products',
                    data: JSON.parse(statusCanvas.dataset.values),
                    backgroundColor: ['#6f9b78', '#c17b7b'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
