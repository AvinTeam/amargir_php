<?php
require_once 'setting.php';

$haspage = (isset($_COOKIE[ 'amargir_login' ])) ? 'home' : 'login';

require_once 'view/' . $haspage . ".php";
