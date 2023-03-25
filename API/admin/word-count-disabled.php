<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$field = isset($_GET['field']) ? $_GET['field'] : null;
$words_search = isset($_GET['words_search']) ? $_GET['words_search'] : '';

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

$query = "SELECT COUNT(*) AS COUNT FROM tbl_words WHERE $field LIKE '$words_search%' AND DATE_DISABLED IS NOT NULL";
$response = $crud->query($query)[0];

echo json_encode($response);