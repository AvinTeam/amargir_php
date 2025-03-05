<?php
    $sms_db          = new DB('sms');
    $gender_db       = new DB('gender');
    $net_db          = new DB('match_clock');
    $program_mc_db   = new DB('program_mc');
    $program_view_db = new DB('program_view');

    $today = date('Y-m-d');

    $labels3000212 = $data3000212 = $labels30001145 = $data30001145 = [  ];
    $labels3000445 = $data3000445 = [  ];

    for ($i = 0; $i <= 7; $i++) {

        $date = date('Y-m-d', strtotime("-$i days", strtotime($today)));

        $sms_count3000212 = $sms_db->get([
            'sms_key' => 3000212,
            'mr_date' => $date,
         ]);
        $labels3000212[  ] = tarikh($date, 'w');
        $data3000212[  ]   = (is_object($sms_count3000212)) ? $sms_count3000212->sms_count : 0;

        $sms_count30001145 = $sms_db->get([
            'sms_key' => 30001145,
            'mr_date' => $date,
         ]);
        $labels30001145[  ] = tarikh($date, 'w');
        $data30001145[  ]   = (is_object($sms_count30001145)) ? $sms_count30001145->sms_count : 0;

        $sms_count3000445 = $sms_db->get([
            'sms_key' => 3000445,
            'mr_date' => $date,
         ]);
        $labels3000445[  ] = tarikh($date, 'w');
        $data3000445[  ]   = (is_object($sms_count3000445)) ? $sms_count3000445->sms_count : 0;
    }

    $sms_rows = $sms_db->group(
        'sms_key, SUM(sms_count) AS total_count',
        [  ],
        'sms_key'
    );
    $sms_row = [  ];
    foreach ($sms_rows as $key => $value) {
        $sms_row[ $value->sms_key ] = $value->total_count;
    }

    $program_mc = $program_mc_db->group(
        'p_key, SUM(p_count) AS total_p_count',
        [  ],
        'p_key'
    );

    $title_view = [
        '1'     => 'شبکه 1',
        '2'     => 'شبکه 2',
        '3'     => 'شبکه 3 محفل',
        'ofogh' => 'شبکه افق',
        'omid'  => 'شبکه امید',
        'poya'  => 'شبکه پویا',
        'quran' => 'شبکه قرآن',
     ];

    $all_mc_title = [  ];
    $all_mc_count = [  ];
    foreach ($program_mc as $key => $value) {

        $all_mc_title[  ] = $title_view[ $value->p_key ];
        $all_mc_count[  ] = $value->total_p_count;
    }

    $gender = $gender_db->group(
        'SUM(male) AS total_males, SUM(female) AS total_females',
        [  ],
        'p_key'
    );

    $net_rows = $net_db->group(
        'SUM(clock_0) AS clock_0, SUM(clock_6) AS clock_6, SUM(clock_12) AS clock_12, SUM(clock_18) AS clock_18',
        [  ],
    );

?>
<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد</title>
    <link href="/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/assets/css/public.css" rel="stylesheet">

    <script src="/assets/vendor/chart/chart.js"></script>
    <script src="/assets/vendor/chart/chartjs-plugin-datalabels.js"></script>
    <script src="/assets/js/highmaps.js"></script>

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

        <div class="row  row-cols-1 row-cols-md-3 ">
            <div class="col p-2">
                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 mb-5">
                    <span>(سامانه اصلی پویش)</span>
                    <b><?php echo number_format(absint($sms_row[ 3000212 ])) ?></b>
                    <span>3000212</span>
                </div>

                <div>
                    <canvas id="lineChart3000212"></canvas>
                </div>
            </div>
            <div class="col p-2">
                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 mb-5">
                    <span>( سامانه محفل)</span>
                    <b><?php echo number_format($sms_row[ 30001145 ]) ?></b>
                    <span>30001145</span>
                </div>

                <div>
                    <canvas id="lineChart30001145"></canvas>
                </div>
            </div>
            <div class="col p-2">
                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 mb-5">
                    <span>( مسابقه پیامکی ملی)</span>
                    <b><?php echo number_format($sms_row[ 3000445 ]) ?></b>
                    <span>3000445</span>
                </div>

                <div>
                    <canvas id="lineChart3000445"></canvas>
                </div>
            </div>

        </div>




        <div class="row row-cols-1 row-cols-md-2 justify-content-center">


            <div class="col p-2">

                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4">
                    <div id="container"></div>
                </div>

            </div>


            <div class="col row  row-cols-1 row-cols-md-2">
                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'tv' ])) ?></b>
                        <span>مسابقه تلویزیونی</span>
                    </div>
                </div>

                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'net' ])) ?></b>
                        <span>مسابقه اینترنتی</span>
                    </div>
                </div>

                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'online' ])) ?></b>
                        <span>مسابقه لحظه ای</span>
                    </div>
                </div>

                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'info' ])) ?></b>
                        <span>مسابقه آزمون 30 آیه</span>
                    </div>
                </div>

                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'app' ])) ?></b>
                        <span>برنامه کاربردی زندگی با آیه ها</span>
                    </div>
                </div>

                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'landing' ])) ?></b>
                        <span>بازدید لندینگ اصلی زندگی با آیه ها</span>
                    </div>
                </div>

                <div class="col p-2 d-flex  justify-content-center align-items-center">
                    <div
                        class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4 h-100">
                        <b><?php echo number_format($program_view_db->sum("p_count", [ 'p_key' => 'atlas' ])) ?></b>
                        <span>بازدید لندینگ اطلس محافل</span>
                    </div>
                </div>
            </div>

        </div>


        <div class="row  row-cols-1 row-cols-md-2 justify-content-center">
            <div class="col p-2">

                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4">
                    <p class="text-center">بازدید سامانه ها</p>
                    <canvas id="myDoughnutChartMc"></canvas>
                </div>
            </div>
            <div class="col p-2">

                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4">
                    <p class="text-center">میزان مخاطب مسابقه اینترنتی بر حسب ساعت</p>

                    <canvas id="myChartTime"></canvas>
                </div>
            </div>

        </div>


        <div class="row  row-cols-1 row-cols-md-2 justify-content-center">
            <div class="col p-2">
                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4">
                    <p class="text-center">درصد مخاطبین برنامه کاربردی</p>

                    <canvas id="myChartApp"></canvas>
                </div>
            </div>
            <div class="col p-2">

                <div
                    class="col border border-1 border_gray rounded d-flex flex-column justify-content-center align-items-center shadow p-4">
                    <p class="text-center">درصد مخاطبین مسابقه 30 آیه </p>

                    <canvas id="myChartInfo"></canvas>
                </div>
            </div>

        </div>
























    </div>
    <script>
    let labels3000212 = JSON.parse('<?php echo json_encode(array_reverse($labels3000212)); ?>');
    let data3000212 = JSON.parse('<?php echo json_encode(array_reverse($data3000212)); ?>');

    let labels30001145 = JSON.parse('<?php echo json_encode(array_reverse($labels30001145)); ?>');
    let data30001145 = JSON.parse('<?php echo json_encode(array_reverse($data30001145)); ?>');

    let labels3000445 = JSON.parse('<?php echo json_encode(array_reverse($labels3000445)); ?>');
    let data3000445 = JSON.parse('<?php echo json_encode(array_reverse($data3000445)); ?>');

    let all_mc_title = JSON.parse('<?php echo json_encode(($all_mc_title)); ?>');
    let all_mc_count = JSON.parse('<?php echo json_encode(($all_mc_count)); ?>');


    let genderMatch1 = JSON.parse(
        '<?php echo json_encode([ $gender[ 0 ]->total_males, $gender[ 0 ]->total_females ]); ?>');

    let genderMatch2 = JSON.parse(
        '<?php echo json_encode([ $gender[ 1 ]->total_males, $gender[ 1 ]->total_females ]); ?>');


    let netRows = JSON.parse('<?php echo json_encode(array_values((array) $net_rows[ 0 ])); ?>');



    (async () => {

        const topology = await fetch(
            '/json/ir-all.topo.json'
        ).then(response => response.json());

        // نام‌های فارسی استان‌ها
        const persianNames = {

            'ir-ar': 'اردبیل',
            'ir-es': 'اصفهان',
            'ir-al': 'البرز',
            'ir-il': 'ایلام',
            'ir-ea': 'آذربایجان شرقی',
            'ir-wa': 'آذربایجان غربی',
            'ir-bs': 'بوشهر',
            'ir-th': 'تهران',
            'ir-cm': 'چهارمحال و بختیاری',
            'ir-kj': 'خراسان جنوبی',
            'ir-kv': 'خراسان رضوی',
            'ir-ks': 'خراسان شمالی',
            'ir-kz': 'خوزستان',
            'ir-za': 'زنجان',
            'ir-sm': 'سمنان',
            'ir-sb': 'سیستان و بلوچستان',
            'ir-fa': 'فارس',
            'ir-qz': 'قزوین',
            'ir-qm': 'قم',
            'ir-kd': 'کردستان',
            'ir-ke': 'کرمان',
            'ir-bk': 'کرمانشاه',
            'ir-kb': 'کهگیلویه و بویراحمد',
            'ir-go': 'گلستان',
            'ir-gi': 'گیلان',
            'ir-lo': 'لرستان',
            'ir-mn': 'مازندران',
            'ir-mk': 'مرکزی',
            'ir-hg': 'هرمزگان',
            'ir-hd': 'همدان',
            'ir-ya': 'یزد',
        };

        const data = [
            ['ir-ar', <?php echo($sms_row[ 1 ]) ?>],
            ['ir-es', <?php echo($sms_row[ 2 ]) ?>],
            ['ir-al', <?php echo($sms_row[ 3 ]) ?>],
            ['ir-il', <?php echo($sms_row[ 4 ]) ?>],
            ['ir-ea', <?php echo($sms_row[ 5 ]) ?>],
            ['ir-wa', <?php echo($sms_row[ 6 ]) ?>],
            ['ir-bs', <?php echo($sms_row[ 7 ]) ?>],
            ['ir-th', <?php echo($sms_row[ 8 ]) ?>],
            ['ir-cm', <?php echo($sms_row[ 9 ]) ?>],
            ['ir-kj', <?php echo($sms_row[ 10 ]) ?>],
            ['ir-kv', <?php echo($sms_row[ 11 ]) ?>],
            ['ir-ks', <?php echo($sms_row[ 12 ]) ?>],
            ['ir-kz', <?php echo($sms_row[ 13 ]) ?>],
            ['ir-za', <?php echo($sms_row[ 14 ]) ?>],
            ['ir-sm', <?php echo($sms_row[ 15 ]) ?>],
            ['ir-sb', <?php echo($sms_row[ 16 ]) ?>],
            ['ir-fa', <?php echo($sms_row[ 17 ]) ?>],
            ['ir-qz', <?php echo($sms_row[ 18 ]) ?>],
            ['ir-qm', <?php echo($sms_row[ 19 ]) ?>],
            ['ir-kd', <?php echo($sms_row[ 20 ]) ?>],
            ['ir-ke', <?php echo($sms_row[ 21 ]) ?>],
            ['ir-bk', <?php echo($sms_row[ 22 ]) ?>],
            ['ir-kb', <?php echo($sms_row[ 23 ]) ?>],
            ['ir-go', <?php echo($sms_row[ 24 ]) ?>],
            ['ir-gi', <?php echo($sms_row[ 25 ]) ?>],
            ['ir-lo', <?php echo($sms_row[ 26 ]) ?>],
            ['ir-mn', <?php echo($sms_row[ 27 ]) ?>],
            ['ir-mk', <?php echo($sms_row[ 28 ]) ?>],
            ['ir-hg', <?php echo($sms_row[ 29 ]) ?>],
            ['ir-hd', <?php echo($sms_row[ 30 ]) ?>],
            ['ir-ya', <?php echo($sms_row[ 31 ]) ?>],
        ];

        // Create the chart
        Highcharts.mapChart('container', {
            chart: {
                map: topology,
                // غیرفعال کردن دکمه‌های منو
                exporting: {
                    enabled: false
                }
            },

            title: {
                text: 'پیامک استانی'
            },


            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                min: 0,
                minColor: '#FFFFF5', // رنگ روشن‌تر قرمز برای مقادیر کم
                maxColor: '#37BEC1' // رنگ قرمز پررنگ برای مقادیر زیاد
            },

            tooltip: {
                formatter: function() {
                    // نمایش نام فارسی استان و مقدار در tooltip
                    return `<b>${persianNames[this.point['hc-key']] || this.point.name}</b><br>مقدار: ${this.point.value}`;
                },
                style: {
                    fontFamily: 'IRANSansX', // فونت دلخواه
                    fontSize: '14px'
                }
            },

            series: [{
                data: data,
                name: 'داده‌های تصادفی',
                states: {
                    hover: {
                        color: '#8DDAD7' // رنگ قرمز تیره هنگام هاور
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        // نمایش مقدار عددی روی نقشه
                        return this.point.value;
                    },
                    style: {
                        fontFamily: 'IRANSansX', // فونت دلخواه
                        fontSize: '12px',
                        fontWeight: 'bold',
                        color: '#000000' // رنگ متن
                    }
                }
            }]
        });

    })();
    </script>
    <script src="/assets/js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="/assets/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="/assets/vendor/jalalidatepicker/jalalidatepicker.min.js"></script>
    <script src="/assets/js/public.js"></script>
</body>

</html>