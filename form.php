<?php
require_once 'setting.php';

if (
    $_SERVER[ 'REQUEST_METHOD' ] === 'POST' &&
    isset($_POST[ 'submit_btn' ]) &&
    ! empty($_POST[ 'submit_btn' ]) &&
    isset($_POST[ 'csrf_token' ]) &&
    $_POST[ 'csrf_token' ] === $_SESSION[ 'csrf_token' ]

) {
    if ($_POST[ 'submit_btn' ] == 'login') {

        $user_db = new DB('user');

        $user = $user_db->get([
            'user_username' => $_POST[ 'username' ],
            'user_password' => md5(md5($_POST[ 'password' ])),
         ]);

        if ($user) {

            $user_verify = generate_password(40);

            echo $user_db->update(
                [ 'user_verify' => $user_verify ],
                [ 'id' => $user->id ]

            );

            setcookie("amargir_login", $user_verify, time() + (15 * 24 * 60), "/");
        }

    }

    header('Location: /');

}
