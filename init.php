<?php

$test = new DB('');

if (isset($_COOKIE[ 'amargir_login' ])) {

    $user_db = new DB('user');

    $user = $user_db->get([
        'user_verify' => $_COOKIE[ 'amargir_login' ],
     ]);

    if (! $user) {

        print_r($user);

        $_SESSION = [  ];
        setcookie('amargir_login', '', time() - 3600, '/'); // حذف کوکی

        session_destroy();

        header('Location: ' . AMARGIR_URL);

    }

}
if (empty($_SESSION[ 'csrf_token' ])) {
    $_SESSION[ 'csrf_token' ] = bin2hex(random_bytes(32));
}