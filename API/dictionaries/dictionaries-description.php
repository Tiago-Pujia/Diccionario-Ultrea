<?php
if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

$id_dictionary = $_GET['id_dictionary'];

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = "SELECT NAME, DATE_CREATION FROM tbl_dictionaries WHERE DATE_DISABLED IS NULL AND ID_DICTIONARY = $id_dictionary;";
$response = $crud->query($query)[0];

echo json_encode($response);