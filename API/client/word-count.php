<?php
if(!isset($_GET['words_search'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$field = isset($_GET['field']) ? $_GET['field'] : null;
$words_search = $_GET['words_search'];

switch ($field) {
    case 'pronunciation':
        $field = 'PRONUNCIATION';
        break;

    case 'significance':
        $field = 'SIGNIFICANSE';
        break;

    default:
        $field = 'WORD';
        break;
}

$query = "SELECT COUNT(*) AS COUNT FROM $tableBD WHERE $field LIKE '$words_search%' AND ISNULL(DATE_DISABLED)";
$response = $crud->query($query)[0];

echo json_encode($response);