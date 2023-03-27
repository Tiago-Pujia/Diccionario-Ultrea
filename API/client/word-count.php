<?php
if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$id_dictionary = $_GET['id_dictionary'];
$field = $getData('field',null);
$words_search = $getData('words_search');
$type_word = $getData('id_type_word');

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
    ? "AND ID_TYPE_WORD = $type_word"
    : '';

$query = 
"SELECT 
    COUNT(*) AS COUNT 
FROM 
    tbl_words 
WHERE 
    $field LIKE '$words_search%' 
    $type_word AND 
    ISNULL(DATE_DISABLED) AND 
    ID_DICTIONARY = $id_dictionary";

$response = $crud->query($query)[0];

echo json_encode($response);