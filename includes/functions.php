<?php

function sanitize_text($text)
{
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
    $text = strip_tags($text);

    return $text;

}
function generate_password($length = 12) {
    // مجموعه کاراکترهای مجاز
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    // ترکیب تمام کاراکترها
    $all_characters = $uppercase . $lowercase . $numbers . $symbols;

    // طول کل کاراکترها
    $total_characters = strlen($all_characters);

    // ایجاد رمز
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $random_index = random_int(0, $total_characters - 1);
        $password .= $all_characters[$random_index];
    }

    return $password;
}

