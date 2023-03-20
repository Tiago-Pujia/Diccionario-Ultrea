<?php
if(!isset($_COOKIE['session']) || $_COOKIE['session'] != 'ak92nd9'){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['id_word'])){
    echo 'Error: Falta de Datos';
    exit();
}

$id_word = $_GET['id_word'];

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = "SELECT WORD,PRONUNCIATION,SIGNIFICANSE FROM $tableBD WHERE ID_WORD = $id_word AND DATE_DISABLED IS NOT NULL;";
$response = $crud->query($query)[0];

echo json_encode($response);

