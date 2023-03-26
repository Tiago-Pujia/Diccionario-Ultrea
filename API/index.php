<?php
// include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

include_once 'crud.php';

$getData = fn($name,$default = '') => isset($_GET[$name]) ? $_GET[$name] : $default;