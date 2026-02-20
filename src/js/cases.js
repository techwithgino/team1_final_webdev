// this whole thing waits until the page has fully loaded
// without it, the script might try to access elements that don't exist yet
document.addEventListener("DOMContentLoaded", function () {

 
    // SEARCH BAR FUNCTIONALITY
   

    // grab the search input field from the page, if the page doesnt have one nothing breaks
   
    const searchInput = document.getElementById('searchInput');

    // Only run the search logic if the search bar actually exists
    if (searchInput) {

        // every time the user types something, this function runs
        searchInput.addEventListener('keyup', function() {

            // take whatever the user typed and convert it to lowercase.
            // it just  makes the search case‑insensitive
            const filter = this.value.toLowerCase();

            // Get all table rows inside <tbody>
            // These are the rows we want to show/hide based on the search
            const rows = document.querySelectorAll('tbody tr');

            // looping through every row in the table
            rows.forEach(row => {

                // Get the text inside the row (also lowercase)
                // this lets us compare it with the search text
                const text = row.innerText.toLowerCase();

                // If the row contains the search text, show it, if not we hide it
                
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }


  
    // PIE CHART FUNCTIONALITY


    // Find the canvas element where the chart should appear
    const chartCanvas = document.getElementById('caseChart');

    // Only run the chart code if the canvas exists.
    if (chartCanvas) {

        // Pull the numbers from the HTML element's data-* attributes
        // These values come from PHP and represent case counts
        const open = parseInt(chartCanvas.dataset.open);
        const progress = parseInt(chartCanvas.dataset.progress);
        const closed = parseInt(chartCanvas.dataset.closed);

        // Create a new pie chart using Chart.js.
        // This visualizes the case status distribution.
        new Chart(chartCanvas, {
            type: 'pie',

            data: {
                // labels that appear in the chart legend.
                labels: ['Open', 'In Progress', 'Closed'],

                datasets: [{
                    // yhe actual numbers for each slice of the pie.
                    data: [open, progress, closed],

                    // Custom brand colors so the chart matches your site.
                    backgroundColor: [
                        '#00887A', // Open
                        '#4FB3A5', // In Progress
                        '#C9A227'  // Closed
                    ],

                    // Slightly darker borders for a cleaner look
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
                            // Make the legend text match your site's color palette
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




