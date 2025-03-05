<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد</title>
    <link href="/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/assets/css/public.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <style>

    </style>
</head>

<body>
    <header class="header d-flex justify-content-between align-items-center p-2 bg-light">
        <h1>داشبورد</h1>
        <div>
            <?php if ($user->user_type == 'admin') {?>
            <a href="/?import" class="btn btn-info">ورود اطلاعات</a>
            <?php }?>
            <button class="btn btn-danger">خروج</button>
        </div>
    </header>
    <div class="content container">
        <div class="row">
            <div class="col-md-3">
                <div class="box text-center">
                    <h2>عدد 1</h2>
                    <p>توضیحات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box text-center">
                    <h2>عدد 2</h2>
                    <p>توضیحات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box text-center">
                    <h2>عدد 3</h2>
                    <p>توضیحات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box text-center">
                    <h2>عدد 4</h2>
                    <p>توضیحات</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="lineChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="iranMap" class="box">
                    <!-- نقشه ایران -->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Iran_location_map.svg" alt="Iran Map"
                        class="img-fluid">
                    <!-- Add numbers to each province as needed -->
                </div>
            </div>
        </div>
    </div>
    <script>
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
            datasets: [{
                    label: 'نمودار خطی 1',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'نمودار خطی 2',
                    data: [5, 10, 15, 20, 25, 30],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    const doughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['قرمز', 'آبی', 'زرد'],
            datasets: [{
                label: 'نمودار دایره‌ای',
                data: [10, 20, 30],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    formatter: (value, context) => {
                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const percentage = (value / total * 100).toFixed(2) + '%';
                        return percentage;
                    },
                    color: '#000', // Change text color to black
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.raw !== null) {
                                label += context.raw + ' (' + Math.round(context.raw / context.chart
                                    ._metasets[context.datasetIndex].total * 100) + '%)';
                            }
                            return label;
                        }
                    }
                },
                doughnutlabel: {
                    labels: [{
                            text: 'جمع کل',
                            font: {
                                size: '20'
                            }
                        },
                        {
                            text: '60',
                            font: {
                                size: '20',
                                weight: 'bold'
                            }
                        }
                    ]
                }
            }
        },
        plugins: [ChartDataLabels]
    });
    </script>
</body>

</html>