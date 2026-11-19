// Chart configuration and management
let chartInstance = null;
let resizeObserver = null;

// Setup resize observer untuk chart container
function setupChartResizeObserver(chartCanvas) {
    if (resizeObserver) {
        resizeObserver.disconnect();
    }

    if (chartCanvas && chartCanvas.parentElement) {
        resizeObserver = new ResizeObserver(() => {
            resizeChart();
        });

        resizeObserver.observe(chartCanvas.parentElement);

        // Juga observe window resize
        window.addEventListener("resize", () => {
            resizeChart();
        });
    }
}

// Fungsi untuk resize chart
function resizeChart() {
    if (chartInstance && typeof chartInstance.resize === "function") {
        requestAnimationFrame(() => {
            chartInstance.resize();
        });
    }
}

// Initialize chart
function initChart() {
    const ctx = document.getElementById("myChart");
    if (!ctx) return;

    // Destroy existing chart if any
    if (chartInstance) {
        chartInstance.destroy();
    }

    const labels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"];

    const data = {
        labels: labels,
        datasets: [
            {
                label: "Penjualan",
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                    "rgba(255, 205, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(201, 203, 207, 0.2)",
                ],
                borderColor: [
                    "rgb(255, 99, 132)",
                    "rgb(255, 159, 64)",
                    "rgb(255, 205, 86)",
                    "rgb(75, 192, 192)",
                    "rgb(54, 162, 235)",
                    "rgb(153, 102, 255)",
                    "rgb(201, 203, 207)",
                ],
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.7,
                categoryPercentage: 0.8,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: true,
                        color: "rgba(0, 0, 0, 0.05)",
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                },
            },
            animation: {
                duration: 750,
                easing: "easeInOutQuart",
            },
        },
    };

    chartInstance = new Chart(ctx, config);

    // Setup resize observer untuk chart
    setupChartResizeObserver(ctx);

    return chartInstance;
}

// Update chart data (opsional, untuk dynamic data)
function updateChartData(newLabels, newData) {
    if (!chartInstance) return;

    chartInstance.data.labels = newLabels;
    chartInstance.data.datasets[0].data = newData;
    chartInstance.update();
}

// Destroy chart (cleanup)
function destroyChart() {
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }

    if (resizeObserver) {
        resizeObserver.disconnect();
        resizeObserver = null;
    }
}

// Export functions ke global scope
window.initChart = initChart;
window.resizeChart = resizeChart;
window.updateChartData = updateChartData;
window.destroyChart = destroyChart;
