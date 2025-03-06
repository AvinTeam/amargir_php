<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <link href="<?php echo amargir_vendor('bootstrap/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo amargir_vendor('bootstrap/bootstrap.rtl.min.css')?>" rel="stylesheet">
    <link href="<?php echo amargir_css('public.css')?>" rel="stylesheet">

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">ورود</h3>
                <form action="<?php echo AMARGIR_URL?>form.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION[ 'csrf_token' ] ?>">
                    <div class="form-group">
                        <label for="username" class="text-start">نام کاربری</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-end">رمز عبور</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="submit_btn" value="login"
                        class="btn btn-primary btn-block">ورود</button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo amargir_js('jquery-3.7.1.min.js') ?>" crossorigin="anonymous"></script>
    <script src="<?php echo amargir_vendor('bootstrap/bootstrap.min.js')?>"></script>
</body>

</html>