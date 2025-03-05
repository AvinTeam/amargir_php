<?php
require_once 'setting.php';

$haspage = (isset($_COOKIE[ 'amargir_login' ])) ? 'dashbord' : 'login';

require_once $haspage . ".php";


