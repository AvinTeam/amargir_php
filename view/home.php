<?php

$haspage = (isset($_GET[ 'import' ])) ? 'import' : 'dashbord';

require_once 'view/' . $haspage . ".php";
