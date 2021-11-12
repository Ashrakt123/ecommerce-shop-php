<?php
include 'connect.php';
$tmp ="includes/templates/";
$css ="layout/css/";
$js ="layout/js/";
$lang ='includes/languages/';
$func	= 'includes/functions/'; // Functions Directory
include $func .'functions.php';

include $lang.'english.php';
include $tmp .'header.php';

if(!isset($nonavbar)){include $tmp .'navbar.php';}