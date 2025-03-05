<?php

function sanitize_text($text)
{
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
    $text = strip_tags($text);

    return $text;

}
function generate_password($length = 12)
{
    // مجموعه کاراکترهای مجاز
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers   = '0123456789';
    $symbols   = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    // ترکیب تمام کاراکترها
    $all_characters = $uppercase . $lowercase . $numbers . $symbols;

    // طول کل کاراکترها
    $total_characters = strlen($all_characters);

    // ایجاد رمز
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $random_index = random_int(0, $total_characters - 1);
        $password .= $all_characters[ $random_index ];
    }

    return $password;
}

function absint($value): int
{
    $int_value = (int) $value;
    return abs($int_value);
}

function tarikh($data, $type = '')
{

    $data_array = explode(" ", $data);

    $data = $data_array[ 0 ];
    $time = (sizeof($data_array) >= 2) ? $data_array[ 1 ] : 0;

    $has_mode = (strpos($data, '-')) ? '-' : '/';

    list($y, $m, $d) = explode($has_mode, $data);

    $ch_date = (strpos($data, '-')) ? gregorian_to_jalali($y, $m, $d, '/') : jalali_to_gregorian($y, $m, $d, '-');

    $has_mode = (strpos($ch_date, '-')) ? '-' : '/';

    list($y, $m, $d) = explode($has_mode, $ch_date);
    if ($m < 10) {$m = '0' . $m;}
    if ($d < 10) {$d = '0' . $d;}

    $ch_date = $y . $has_mode . $m . $has_mode . $d;

    if ($type == 'time') {
        $new_date = $time;
    } elseif ($type == 'date') {
        $new_date = $ch_date;
    } else {
        $new_date = ($time === 0) ? $ch_date : $ch_date . ' ' . $time;
    }

    return $new_date;

}
