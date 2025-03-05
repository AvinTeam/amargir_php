jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr"
});

let lineCtx3000212 = document.getElementById('lineChart3000212');
if (lineCtx3000212) {
    lineCtx3000212 = lineCtx3000212.getContext('2d');

    new Chart(lineCtx3000212, {
        type: 'bar',
        data: {
            labels: labels3000212,
            datasets: [{
                label: 3000212,
                data: data3000212,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: 'IRANSansX'
                        }
                    },
                }
            }
        }
    });

}

let lineCtx30001145 = document.getElementById('lineChart30001145');
if (lineCtx30001145) {
    lineCtx30001145 = lineCtx30001145.getContext('2d');

    new Chart(lineCtx30001145, {
        type: 'bar',
        data: {
            labels: labels30001145,
            datasets: [{
                label: 30001145,
                data: data30001145,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: 'IRANSansX'
                        }
                    },
                }
            }
        }
    });

}

let lineCtx3000445 = document.getElementById('lineChart3000445');
if (lineCtx3000445) {
    lineCtx3000445 = lineCtx3000445.getContext('2d');

    new Chart(lineCtx3000445, {
        type: 'bar',
        data: {
            labels: labels3000445,
            datasets: [{
                label: 3000445,
                data: data3000445,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: 'IRANSansX'
                        }
                    },
                }
            }
        }
    });




}

let chartMc = document.getElementById('myDoughnutChartMc');
if (chartMc) {

    chartMc = chartMc.getContext('2d');
    // داده‌های نمودار
    const data = {
        labels: all_mc_title, // عنوان بخش‌ها
        datasets: [{
            data: all_mc_count, // مقادیر مربوط به هر بخش
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)',
                'rgba(199, 199, 199, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)'
            ],
            borderWidth: 1
        }]
    };

    // تنظیمات نمودار
    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom', // موقعیت توضیحات (legend)
                rtl: true, // راست‌چین کردن توضیحات
                labels: {
                    font: {
                        size: 14,
                        family: 'IRANSansX' // استفاده از فونت IRANSansX
                    }
                }
            },
            tooltip: {
                enabled: true,
                rtl: true, // راست‌چین کردن tooltip
                bodyFont: {
                    size: 14,
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                }
            },
            // افزودن متن داخل نمودار
            datalabels: {
                color: '#000', // رنگ متن
                font: {
                    size: 16,
                    weight: 'bold',
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                },
                formatter: (value, context) => {
                    //return context.chart.data.labels[context.dataIndex]; // نمایش عنوان هر بخش
                }
            }
        }
    };

    // ایجاد نمودار
    const myDoughnutChartMc = new Chart(chartMc, {
        type: 'doughnut',
        data: data,
        options: options,
        plugins: [ChartDataLabels] // افزودن پلاگین برای نمایش متن داخل نمودار
    });

}

let myChartApp = document.getElementById('myChartApp');
if (myChartApp) {

    myChartApp = myChartApp.getContext('2d');
    // داده‌های نمودار
    const data = {
        labels: ['مرد', 'زن'], // عنوان بخش‌ها
        datasets: [{
            data: genderMatch1, // مقادیر مربوط به هر بخش
            backgroundColor: [

                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 99, 132, 0.6)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    };

    // تنظیمات نمودار
    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom', // موقعیت توضیحات (legend)
                rtl: true, // راست‌چین کردن توضیحات
                labels: {
                    font: {
                        size: 14,
                        family: 'IRANSansX' // استفاده از فونت IRANSansX
                    }
                }
            },
            tooltip: {
                enabled: true,
                rtl: true, // راست‌چین کردن tooltip
                bodyFont: {
                    size: 14,
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                }
            },
            // افزودن متن داخل نمودار
            datalabels: {
                color: '#000', // رنگ متن
                font: {
                    size: 16,
                    weight: 'bold',
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                },
                formatter: (value, context) => {
                    //return context.chart.data.labels[context.dataIndex]; // نمایش عنوان هر بخش
                }
            }
        }
    };

    // ایجاد نمودار
    const myDoughnutChartMc = new Chart(myChartApp, {
        type: 'doughnut',
        data: data,
        options: options,
        plugins: [ChartDataLabels] // افزودن پلاگین برای نمایش متن داخل نمودار
    });

}

let myChartInfo = document.getElementById('myChartInfo');
if (myChartInfo) {

    myChartInfo = myChartInfo.getContext('2d');
    // داده‌های نمودار
    const data = {
        labels: ['مرد', 'زن'], // عنوان بخش‌ها
        datasets: [{
            data: genderMatch2, // مقادیر مربوط به هر بخش
            backgroundColor: [

                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 99, 132, 0.6)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    };

    // تنظیمات نمودار
    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom', // موقعیت توضیحات (legend)
                rtl: true, // راست‌چین کردن توضیحات
                labels: {
                    font: {
                        size: 14,
                        family: 'IRANSansX' // استفاده از فونت IRANSansX
                    }
                }
            },
            tooltip: {
                enabled: true,
                rtl: true, // راست‌چین کردن tooltip
                bodyFont: {
                    size: 14,
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                }
            },
            // افزودن متن داخل نمودار
            datalabels: {
                color: '#000', // رنگ متن
                font: {
                    size: 16,
                    weight: 'bold',
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                },
                formatter: (value, context) => {
                    //return context.chart.data.labels[context.dataIndex]; // نمایش عنوان هر بخش
                }
            }
        }
    };

    // ایجاد نمودار
    const myDoughnutChartMc = new Chart(myChartInfo, {
        type: 'doughnut',
        data: data,
        options: options,
        plugins: [ChartDataLabels] // افزودن پلاگین برای نمایش متن داخل نمودار
    });

}

let myChartTime = document.getElementById('myChartTime');
if (myChartTime) {

    myChartTime = myChartTime.getContext('2d');
    // داده‌های نمودار
    const data = {
        labels: [
            'ساعت 0 الی 6',
            'ساعت 6 الی 12',
            'ساعت 12 الی 18',
            'ساعت 18 الی 0',
        ],
        datasets: [{
            data: netRows, // مقادیر مربوط به هر بخش
            backgroundColor: [
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 159, 64, 0.6)',
                'rgba(199, 199, 199, 0.6)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)'
            ],
            borderWidth: 1
        }]
    };

    // تنظیمات نمودار
    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom', // موقعیت توضیحات (legend)
                rtl: true, // راست‌چین کردن توضیحات
                labels: {
                    font: {
                        size: 14,
                        family: 'IRANSansX' // استفاده از فونت IRANSansX
                    }
                }
            },
            tooltip: {
                enabled: true,
                rtl: true, // راست‌چین کردن tooltip
                bodyFont: {
                    size: 14,
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                }
            },
            // افزودن متن داخل نمودار
            datalabels: {
                color: '#000', // رنگ متن
                font: {
                    size: 16,
                    weight: 'bold',
                    family: 'IRANSansX' // استفاده از فونت IRANSansX
                },
                formatter: (value, context) => {
                    //return context.chart.data.labels[context.dataIndex]; // نمایش عنوان هر بخش
                }
            }
        }
    };

    // ایجاد نمودار
    const myDoughnutChartMc = new Chart(myChartTime, {
        type: 'doughnut',
        data: data,
        options: options,
        plugins: [ChartDataLabels] // افزودن پلاگین برای نمایش متن داخل نمودار
    });

}