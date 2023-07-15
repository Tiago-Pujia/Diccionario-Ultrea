<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/verify-session.php';
if($verifySessionAdmin){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$words_search = $getData('words_search');
$words_search = str_replace("'","\'",$words_search);
$words_search = str_replace('"','\"',$words_search);

$page = $getData('page',0);
$id_dictionary = $_GET['id_dictionary'];

$jumps = 25;
$pageSql = $page*$jumps;

$query = <<<EOT
SELECT 
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
LIMIT $pageSql,$jumps;
EOT;

$response = $crud->query($query);
echo json_encode($response);