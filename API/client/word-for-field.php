<?php
if(!isset($_GET['words_search'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$getData = fn($name,$default = '') => isset($_GET[$name]) ? $_GET[$name] : $default;

$words_search = $_GET['words_search'];
$field = $getData('field',null);;
$page = $getData('page',0);

$jumps = 25;
$pageSql = $page*$jumps;

switch ($field) {
    case 'pronunciation':
        $field = 'PRONUNCIATION';
        break;

    case 'significance':
        $field = 'SIGNIFICANCE';
        break;

    default:
        $field = 'WORD';
        break;
}

$query = "SELECT ID_WORD, $field AS WORD FROM tbl_words WHERE $field LIKE '$words_search%' AND ISNULL(DATE_DISABLED) ORDER BY WORD ASC LIMIT $pageSql,$jumps;";
$response = $crud->query($query);
echo json_encode($response);
