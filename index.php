
<?php
define('AMARGIR_VERSION', '1.0.0');


require_once 'setting.php';

$haspage = (isset($_COOKIE[ 'amargir_login' ])) ? 'home' : 'login';

require_once 'view/' . $haspage . ".php";
