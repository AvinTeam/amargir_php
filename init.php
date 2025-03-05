<?php

if (isset($_COOKIE[ 'amargir_login' ])) {

    $user_db = new DB('user');

    $user = $user_db->get([
        'user_verify' => $_COOKIE[ 'amargir_login' ],
     ]);

    if (! $user) {

        $_SESSION = [  ];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params[ "path" ],
                $params[ "domain" ],
                $params[ "secure" ],
                $params[ "httponly" ]
            );
        }

        session_destroy();

    }

}
if (empty($_SESSION[ 'csrf_token' ])) {
    $_SESSION[ 'csrf_token' ] = bin2hex(random_bytes(32));
}
