<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = "SELECT ID_TYPE, NAME FROM tbl_type_word";
$response = $crud->query($query);

echo json_encode($response);