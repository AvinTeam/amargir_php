<?php

require_once 'setting.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            'user_username' => sanitize_text($_POST[ 'username' ]),
            'user_password' => md5(md5($_POST[ 'password' ])),
         ]);

        if ($user) {

            $user_verify = generate_password(40);

            echo $user_db->update(
                [ 'user_verify' => $user_verify ],
                [ 'id' => $user->id ]

            );

            setcookie("amargir_login", $user_verify, time() + (15 * 24 * 60 * 60), "/");
        }

    }

    if ($_POST[ 'submit_btn' ] == 'import') {

        $file_date = tarikh($_POST[ 'date_file' ]);

        $sms_db          = new DB('sms');
        $gender_db       = new DB('gender');
        $net_db          = new DB('match_clock');
        $program_mc_db   = new DB('program_mc');
        $program_view_db = new DB('program_view');

        if (isset($_FILES[ 'excel_file' ]) && $_FILES[ 'excel_file' ][ 'error' ] === UPLOAD_ERR_OK) {
            $fileTmpPath   = $_FILES[ 'excel_file' ][ 'tmp_name' ];
            $fileName      = $_FILES[ 'excel_file' ][ 'name' ];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // بررسی فرمت فایل
            $allowedExtensions = [ 'xls', 'xlsx' ];
            if (! in_array($fileExtension, $allowedExtensions)) {
                die("فرمت فایل پشتیبانی نمی‌شود. لطفاً یک فایل اکسل انتخاب کنید.");
            }

            try {
                // خواندن فایل اکسل
                $spreadsheet = IOFactory::load($fileTmpPath);
                $sheet       = $spreadsheet->getActiveSheet();          // شیت فعال
                $data        = $sheet->toArray(null, true, true, true); // تبدیل به آرایه

                $end_array = [  ];

                $net_row = $gender = '';

                foreach ($data as $rowIndex => $row) {

                    if ($rowIndex === 1) {continue;}

                    if ($row[ 'A' ] == 'sms') {

                        $is_update = $sms_db->num([
                            'sms_key' => $row[ 'B' ],
                            'mr_date' => $file_date ]);

                        if ($is_update) {

                            $sms_db->update(
                                [ 'sms_count' => absint($row[ 'C' ]) ],
                                [
                                    'sms_key' => $row[ 'B' ],
                                    'mr_date' => $file_date,
                                 ]
                            );

                        } else {
                            $sms_db->insert([
                                'sms_key'   => $row[ 'B' ],
                                'sms_count' => absint($row[ 'C' ]),
                                'mr_date'   => $file_date,
                             ]);
                        }

                    } elseif (strpos($row[ 'A' ], 'sms_o_') === 0) {
                        $number = substr($row[ 'A' ], strlen('sms_o_'));

                        $is_update = $sms_db->num([
                            'sms_key' => absint($number),
                            'mr_date' => $file_date ]);

                        if ($is_update) {

                            $sms_db->update(
                                [ 'sms_count' => absint($row[ 'C' ]) ],
                                [
                                    'sms_key' => absint($number),
                                    'mr_date' => $file_date,
                                 ]
                            );

                        } else {
                            $sms_db->insert([
                                'sms_key'   => absint($number),
                                'sms_count' => absint($row[ 'C' ]),
                                'mr_date'   => $file_date,
                             ]);
                        }

                    } elseif (strpos($row[ 'A' ], 'p_view_') === 0) {
                        $type = substr($row[ 'A' ], strlen('p_view_'));

                        $is_update = $program_view_db->num([
                            'p_key'   => $type,
                            'mr_date' => $file_date ]);

                        if ($is_update) {

                            $program_view_db->update(
                                [ 'p_count' => absint($row[ 'C' ]) ],
                                [
                                    'p_key'   => $type,
                                    'mr_date' => $file_date,
                                 ]
                            );

                        } else {
                            $program_view_db->insert([
                                'p_key'   => $type,
                                'p_count' => absint($row[ 'C' ]),
                                'mr_date' => $file_date,
                             ]);
                        }

                    } elseif (strpos($row[ 'A' ], 'p_mc_') === 0) {
                        $type = substr($row[ 'A' ], strlen('p_mc_'));

                        $is_update = $program_mc_db->num([
                            'p_key'   => $type,
                            'mr_date' => $file_date ]);

                        if ($is_update) {

                            $program_mc_db->update(
                                [ 'p_count' => absint($row[ 'C' ]) ],
                                [
                                    'p_key'   => $type,
                                    'mr_date' => $file_date,
                                 ]
                            );

                        } else {
                            $program_mc_db->insert([
                                'p_key'   => $type,
                                'p_count' => absint($row[ 'C' ]),
                                'mr_date' => $file_date,
                             ]);
                        }

                    } elseif (strpos($row[ 'A' ], 'g_1_') === 0) {
                        $type = substr($row[ 'A' ], strlen('g_1_'));

                        $type = ($type == 'male') ? 'male' : 'female';

                        $end_array[ 'gender' ][ 1 ][ 'p_key' ] = $type;
                        $end_array[ 'gender' ][ 1 ][ $type ]   = absint($row[ 'C' ]);

                    } elseif (strpos($row[ 'A' ], 'g_2_') === 0) {
                        $type = substr($row[ 'A' ], strlen('g_2_'));

                        $type = ($type == 'male') ? 'male' : 'female';

                        $end_array[ 'gender' ][ 2 ][ 'p_key' ] = $type;
                        $end_array[ 'gender' ][ 2 ][ $type ]   = absint($row[ 'C' ]);

                    } elseif (strpos($row[ 'A' ], 'net_') === 0) {
                        $net_row = substr($row[ 'A' ], strlen('net_'));

                        $end_array[ 'net' ][ 'clock_' . $net_row ] = absint($row[ 'C' ]);

                    }
                }

                if (! empty($end_array[ 'net' ])) {

                    $net = $end_array[ 'net' ];

                    $is_update = $net_db->num([ 'mr_date' => $file_date ]);

                    if ($is_update) {

                        $net_db->update(
                            [
                                'clock_0'  => $net[ 'clock_0' ],
                                'clock_6'  => $net[ 'clock_6' ],
                                'clock_12' => $net[ 'clock_12' ],
                                'clock_18' => $net[ 'clock_18' ],
                             ],
                            [ 'mr_date' => $file_date ]
                        );

                    } else {
                        $net_db->insert([
                            'clock_0'  => $net[ 'clock_0' ],
                            'clock_6'  => $net[ 'clock_6' ],
                            'clock_12' => $net[ 'clock_12' ],
                            'clock_18' => $net[ 'clock_18' ],
                            'mr_date'  => $file_date,
                         ]);
                    }
                }

                if (! empty($end_array[ 'gender' ])) {

                    $gender = $end_array[ 'gender' ];

                    foreach ($gender as $key => $value) {

                        $is_update = $gender_db->num([
                            'p_key'   => $key,
                            'mr_date' => $file_date,
                         ]);

                        if ($is_update) {

                            $gender_db->update(
                                [
                                    'male'   => $value[ 'male' ],
                                    'female' => $value[ 'female' ],
                                 ],
                                [
                                    'p_key'   => $key,
                                    'mr_date' => $file_date,
                                 ]
                            );

                        } else {
                            $gender_db->insert([
                                'p_key'   => $key,
                                'male'    => $value[ 'male' ],
                                'female'  => $value[ 'female' ],
                                'mr_date' => $file_date,
                             ]);
                        }

                    }
                }
            } catch (Exception $e) {
                die("خطا در خواندن فایل اکسل: " . $e->getMessage());
            }
        } else {
            die("لطفاً یک فایل اکسل آپلود کنید.");
        }

    }

    header('Location: ' . AMARGIR_URL);

}