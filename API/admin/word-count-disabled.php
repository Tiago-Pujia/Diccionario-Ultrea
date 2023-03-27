<?php
if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$field = $getData('field',null);
$words_search = $getData('words_search');
$id_dictionary = $_GET['id_dictionary'];

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

$query = 
"SELECT 
    COUNT(*) AS COUNT 
FROM 
    tbl_words 
WHERE 
    $field LIKE '$words_search%' AND 
    DATE_DISABLED IS NOT NULL AND
    ID_DICTIONARY = $id_dictionary";

$response = $crud->query($query)[0];

echo json_encode($response);