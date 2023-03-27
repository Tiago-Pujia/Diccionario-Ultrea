<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = "SELECT ID_DICTIONARY, NAME, DATE_CREATION FROM tbl_dictionaries WHERE DATE_DISABLED IS NULL;";
$response = $crud->query($query);

echo json_encode($response);