<?php
if(!isset($_GET['words_search'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$words_search = $_GET['words_search'];
$field = $getData('field',null);;
$type_word = $getData('id_type_word');
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

$type_word = is_numeric($type_word)
    ? "AND tbl_words.ID_TYPE_WORD = $type_word"
    : '';

$query = 
"SELECT 
    tbl_words.ID_WORD AS ID_WORD, 
    $field AS WORD
FROM 
    tbl_words
LEFT JOIN
    tbl_type_word ON tbl_type_word.ID_TYPE = tbl_words.ID_TYPE_WORD
WHERE 
    $field LIKE '$words_search%'
    $type_word AND 
    ISNULL(tbl_words.DATE_DISABLED) 
    
    ORDER BY tbl_words.WORD ASC 
    LIMIT $pageSql,$jumps;";

$response = $crud->query($query);
echo json_encode($response);