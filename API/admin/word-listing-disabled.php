<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/admin/verify-session.php';
if($verifySession){
    exit('Error: se requiere permisos de admin');
}

$getData = fn($name,$default = '') => isset($_GET[$name]) ? $_GET[$name] : $default;

$page = $getData('page',0);
$words_search = $getData('words_search');

$jumps = 25;
$pageSql = $page*$jumps;

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';
$query = "SELECT ID_WORD, WORD, SIGNIFICANCE, DATE_DISABLED FROM tbl_words WHERE DATE_DISABLED IS NOT NULL AND WORD LIKE '$words_search%' ORDER BY WORD ASC LIMIT $pageSql,$jumps;";
$response = $crud->query($query);
echo json_encode($response);