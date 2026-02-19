document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }

    const chartCanvas = document.getElementById('caseChart');

    if (chartCanvas) {
        const open = parseInt(chartCanvas.dataset.open);
        const progress = parseInt(chartCanvas.dataset.progress);
        const closed = parseInt(chartCanvas.dataset.closed);

        new Chart(chartCanvas, {
            type: 'pie',
            data: {
                labels: ['Open', 'In Progress', 'Closed'],
                datasets: [{
                    data: [open, progress, closed],

                    // ⭐ YOUR BRAND COLORS (no more bright defaults)
                    backgroundColor: [
                        '#00887A', // Open
                        '#4FB3A5', // In Progress
                        '#C9A227'  // Closed
                    ],

                    borderColor: [
                        '#006f63',
                        '#3a8f82',
                        '#a7841f'
                    ],

                    borderWidth: 2
                }]
            },

            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#003135',
                            font: {
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    }
                }
            }
        });
    }
});



