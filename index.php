<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Tehran');


require_once 'config_test.php';
//require_once 'config.php';


require_once 'classes/db.php';
require_once 'classes/IRAN.php';



require_once 'init.php';


$haspage = (isset($_COOKIE[ 'amargir_login' ])) ? 'dashbord' : 'login';

require_once $haspage . ".php";
