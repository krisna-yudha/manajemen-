// Manager Reports Charts
import Chart from 'chart.js/auto';

// Global chart instances
let rentalTrendChart, statusRentalChart, userStatsChart, kategoriChart;

// Initialize all charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the manager report page
    if (document.getElementById('rentalTrendChart')) {
        initializeCharts();
    }
});

function initializeCharts() {
    // Get data from window object (passed from Blade template)
    const chartData = window.managerReportData || {};
    
    // Initialize each chart
    initRentalTrendChart(chartData);
    initStatusRentalChart(chartData);
    initUserStatsChart(chartData);
    initKategoriChart(chartData);
}

function initRentalTrendChart(data) {
    const ctx = document.getElementById('rentalTrendChart');
    if (!ctx) return;

    rentalTrendChart = new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: data.bulanLabels || [],
            datasets: [{
                label: 'Jumlah Rental',
                data: data.rentalPerBulan || [],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });
}

function initStatusRentalChart(data) {
    const ctx = document.getElementById('statusRentalChart');
    if (!ctx) return;

    const statusData = data.statusRental || {};
    
    statusRentalChart = new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Active', 'Completed', 'Rejected'],
            datasets: [{
                data: [
                    statusData.pending || 0,
                    statusData.approved || 0,
                    statusData.active || 0,
                    statusData.completed || 0,
                    statusData.rejected || 0
                ],
                backgroundColor: [
                    '#fbbf24',
                    '#10b981',
                    '#3b82f6',
                    '#6b7280',
                    '#ef4444'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderWidth: 1
                }
            }
        }
    });
}

function initUserStatsChart(data) {
    const ctx = document.getElementById('userStatsChart');
    if (!ctx) return;

    const userStats = data.userStats || {};
    
    userStatsChart = new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Manager', 'Staff Gudang', 'Member'],
            datasets: [{
                label: 'Jumlah User',
                data: [
                    userStats.manager || 0,
                    userStats.gudang || 0,
                    userStats.member || 0
                ],
                backgroundColor: [
                    '#8b5cf6',
                    '#3b82f6',
                    '#10b981'
                ],
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

function initKategoriChart(data) {
    const ctx = document.getElementById('kategoriChart');
    if (!ctx) return;

    kategoriChart = new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: data.kategoriLabels || [],
            datasets: [{
                label: 'Tersedia',
                data: data.kategoriTersedia || [],
                backgroundColor: '#10b981',
                borderRadius: 4,
                borderSkipped: false
            }, {
                label: 'Dirental',
                data: data.kategoriRental || [],
                backgroundColor: '#ef4444',
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    stacked: true,
                    grid: {
                        display: false
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Function to update charts with new data (for future use)
window.updateManagerReports = function(newData) {
    window.managerReportData = newData;
    
    // Destroy existing charts
    if (rentalTrendChart) rentalTrendChart.destroy();
    if (statusRentalChart) statusRentalChart.destroy();
    if (userStatsChart) userStatsChart.destroy();
    if (kategoriChart) kategoriChart.destroy();
    
    // Reinitialize with new data
    initializeCharts();
};

export { initializeCharts };
