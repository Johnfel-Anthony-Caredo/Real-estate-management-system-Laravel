<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head') 
</head>
<body>
    <!-- Sidenav -->
    @include('partials._sidebar') 

    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        @include('partials._topnav') 

        <!-- Header -->
        <div style="background-image: url({{ asset('assets/img/theme/restro00.jpg') }}); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-4"></span>
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Admins</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $adminCount ?? 0 }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Users</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $userCount ?? 0 }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                                <i class="fas fa-user-cog"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Properties</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $propertyCount ?? 0 }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Hometypes</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $homeTypeCount ?? 0 }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                                <i class="fas fa-home"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="container-fluid mt--7">
            <!-- Monthly Data Charts -->
            <div class="row">
                <!-- Bar Chart - Monthly Growth -->
                <div class="col-xl-8 mb-5 mb-xl-0">
                    <div class="card bg-gradient-default shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                                    <h2 class="text-white mb-0">Monthly Growth ({{ date('Y') }})</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                <canvas id="monthlyGrowthChart" class="chart-canvas" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pie Chart - Distribution -->
                <div class="col-xl-4">
                    <div class="card bg-gradient-default shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-light ls-1 mb-1">Distribution</h6>
                                    <h2 class="text-white mb-0">Overall Breakdown</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                <canvas id="distributionChart" class="chart-canvas" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Most Requested Home Types Chart -->
            <div class="row mt-5">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted ls-1 mb-1">Analysis</h6>
                                    <h2 class="mb-0">Most Requested Property Types</h2>
                                    <p class="text-muted text-sm mt-2">Line chart visualization of property requests by home type</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10 mx-auto">
                                    <!-- Chart -->
                                    <div class="chart" style="height: 400px;">
                                        <canvas id="homeTypesChart" class="chart-canvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('partials._footer') 
        </div>
    </div>

    @include('partials._scripts')
    
    <!-- Chart.js initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart colors
            const colors = {
                users: {
                    primary: '#5e72e4',
                    light: 'rgba(94, 114, 228, 0.2)',
                    dark: 'rgba(94, 114, 228, 0.8)'
                },
                admins: {
                    primary: '#fb6340',
                    light: 'rgba(251, 99, 64, 0.2)',
                    dark: 'rgba(251, 99, 64, 0.8)'
                },
                properties: {
                    primary: '#ffd600',
                    light: 'rgba(255, 214, 0, 0.2)',
                    dark: 'rgba(255, 214, 0, 0.8)'
                },
                homeTypes: [
                    '#11cdef', '#2dce89', '#f5365c', '#fb6340', '#5603ad', 
                    '#8965e0', '#f3a4b5', '#ffd600', '#5e72e4', '#172b4d'
                ],
                lineChart: {
                    primary: '#5e72e4',
                    grid: 'rgba(0, 0, 0, 0.1)'
                }
            };
            
            // Chart data
            const chartData = @json($chartData);
            const homeTypesData = @json($homeTypesData);
            
            // Monthly Growth Bar Chart
            const monthlyGrowthCtx = document.getElementById('monthlyGrowthChart').getContext('2d');
            new Chart(monthlyGrowthCtx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Users',
                            data: chartData.users,
                            backgroundColor: colors.users.primary,
                            borderWidth: 1
                        },
                        {
                            label: 'Admins',
                            data: chartData.admins,
                            backgroundColor: colors.admins.primary,
                            borderWidth: 1
                        },
                        {
                            label: 'Properties',
                            data: chartData.properties,
                            backgroundColor: colors.properties.primary,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#fff',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(238, 237, 237, 0.1)'
                            },
                            ticks: {
                                color: '#fff',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
            
            // Distribution Pie Chart
            const distributionCtx = document.getElementById('distributionChart').getContext('2d');
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Users', 'Admins', 'Properties'],
                    datasets: [{
                        data: [
                            {{ $userCount }}, 
                            {{ $adminCount }}, 
                            {{ $propertyCount }}
                        ],
                        backgroundColor: [
                            colors.users.primary,
                            colors.admins.primary,
                            colors.properties.primary
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#fff'
                            }
                        }
                    }
                }
            });
            
            // Most Requested Home Types Chart - Changed to Stepped Line Chart
            const homeTypesCtx = document.getElementById('homeTypesChart').getContext('2d');
            new Chart(homeTypesCtx, {
                type: 'line',
                data: {
                    labels: homeTypesData.labels,
                    datasets: [{
                        label: 'Number of Requests',
                        data: homeTypesData.counts,
                        backgroundColor: 'rgba(94, 114, 228, 0.2)',
                        borderColor: '#5e72e4',
                        borderWidth: 2,
                        pointBackgroundColor: '#5e72e4',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        stepped: 'before', 
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#666',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#666',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                padding: 20,
                                color: '#333'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#333',
                            bodyColor: '#333',
                            borderColor: '#5e72e4',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value} requests`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Distribution of Property Type Requests (Stepped)',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            },
                            color: '#333'
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
