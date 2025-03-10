<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود اطلاعات</title>
    <link href="<?php echo amargir_vendor('bootstrap/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo amargir_vendor('bootstrap/bootstrap.rtl.min.css')?>" rel="stylesheet">
    <link href="<?php echo amargir_vendor('jalalidatepicker/jalalidatepicker.min.css')?>" rel="stylesheet">
    <link href="<?php echo amargir_css('public.css')?>" rel="stylesheet">
</head>

<body>
    <header class="header d-flex justify-content-between align-items-center p-2 bg-light">
        <h1>ورود اطلاعات</h1>
        <div>

            <a href="<?php echo AMARGIR_URL?>" class="btn btn-info">داشبورد</a>
            <button class="btn btn-danger">خروج</button>
        </div>
    </header>
    <div class="container login-container d-flex justify-content-center align-items-center mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">ورود اطلاعات</h3>
                <form action="<?php echo AMARGIR_URL?>form.php" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION[ 'csrf_token' ] ?>">
                    <div class="form-group">
                        <label for="date_file" class="text-start">تاریخ</label>
                        <input type="text" class="form-control" id="date_file" name="date_file" data-jdp=""
                            data-jdp-max-date="today" placeholder=" تاریخ" data-jdp-only-date="" required>
                    </div>
                    <div class="form-group">
                        <label for="excel_file" class="text-end">فایل اکسل</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" required>
                    </div>
                    <button type="submit" name="submit_btn" value="import"
                        class="btn btn-primary btn-block">ورود</button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo amargir_js('jquery-3.7.1.min.js')?>" crossorigin="anonymous"></script>
    <script src="<?php echo amargir_vendor('bootstrap/bootstrap.min.js')?>"></script>
    <script src="<?php echo amargir_vendor('jalalidatepicker/jalalidatepicker.min.js')?>"></script>
    <script src="<?php echo amargir_js('public.js')?>"></script>
</body>

</html>