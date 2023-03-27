<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/verify-session.php';
if($verifySessionAdmin){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

$getData = fn($name,$default = '') => isset($_GET[$name]) ? $_GET[$name] : $default;

$page = $getData('page',0);
$words_search = $getData('words_search');
$id_dictionary = $_GET['id_dictionary'];

$jumps = 25;
$pageSql = $page*$jumps;

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';
$query = 
"SELECT 
    ID_WORD, 
    WORD, 
    SIGNIFICANCE, 
    DATE_DISABLED 
FROM 
    tbl_words 
WHERE 
    DATE_DISABLED IS NOT NULL AND 
    WORD LIKE '$words_search%' AND 
    ID_DICTIONARY = $id_dictionary
ORDER BY WORD ASC 
LIMIT $pageSql,$jumps;";

$response = $crud->query($query);
echo json_encode($response);