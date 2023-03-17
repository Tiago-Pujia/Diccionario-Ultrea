<?php
if(!isset($_GET['words_search']) || !isset($_GET['field'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$field = $_GET['field'];
$words_search = $_GET['words_search'];

switch ($field) {
    default;
    case 'ultrea':
        $field = 'WORD';
        break;

    case 'pronunciation':
        $field = 'PRONUNCIATION';
        break;

    case 'significance':
        $field = 'SIGNIFICANSE';
        break;
}

$query = "SELECT ID_WORD, $field AS WORD FROM $tableBD WHERE $field LIKE '$words_search%';";
$response = $crud->query($query);

echo json_encode($response);
