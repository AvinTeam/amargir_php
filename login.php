<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <link href="/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/assets/css/public.css" rel="stylesheet">
    <style>
    .login-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-group label,
    .btn {
        font-size: 1.25rem;
        /* Larger font size */
    }

    .card {
        width: 100%;
        /* Full width */
        max-width: 500px;
        /* Maximum width */
    }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">ورود</h3>
                <form action="/form.php" method="POST">
                <input type="" name="csrf_token" value="<?php echo $_SESSION[ 'csrf_token' ]?>">
                    <div class="form-group">
                        <label for="username" class="text-start">نام کاربری</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-end">رمز عبور</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="submit_btn" value="login" class="btn btn-primary btn-block">ورود</button>
                </form>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="/assets//vendor/bootstrap/bootstrap.min.js"></script>
</body>

</html>