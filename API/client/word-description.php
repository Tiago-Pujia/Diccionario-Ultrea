<?php
if(!isset($_GET['id_word'])){
    echo 'Error: Falta de Datos';
    exit();
}

$id_word = $_GET['id_word'];

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = "SELECT WORD,PRONUNCIATION,SIGNIFICANCE FROM tbl_words WHERE ID_WORD = $id_word AND ISNULL(DATE_DISABLED);";
$response = $crud->query($query)[0];

echo json_encode($response);

