<?php
if(!isset($_GET['words_search'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$field = isset($_GET['field']) 
    ? $_GET['field'] 
    : null;
$words_search = $_GET['words_search'];

switch ($field) {
    case 'pronunciation':
        $field = 'PRONUNCIATION';
        break;

    case 'significance':
        $field = 'SIGNIFICANSE';
        break;

    default:
    case 'ultrea':
        $field = 'WORD';
        break;
}

$query = "SELECT ID_WORD, $field AS WORD FROM $tableBD WHERE $field LIKE '$words_search%' AND ISNULL(DATE_DISABLED);";
$response = $crud->query($query);

echo json_encode($response);
